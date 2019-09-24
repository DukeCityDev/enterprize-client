import {doubleShift, Shift, WeekTimes} from "../../interfaces";

export const parseMonth = (month: number) => {

    switch(month) {
        case 0:
            return "January";
        case 1:
            return "February";
        case 2:
            return "March";
        case 3:
            return "April";
        case 4:
            return "May";
        case 5:
            return "June";
        case 6:
            return "July";
        case 7:
            return "August";
        case 8:
            return "September";
        case 9:
            return "October";
        case 10:
            return "November";
        case 11:
            return "December";
    }
}

const timeOverlap = (startDate1, endDate1, startDate2,endDate2): boolean =>{
    if(startDate1.getDate() == startDate2.getDate() && startDate1.getMonth() == startDate2.getMonth() && startDate1.getUTCFullYear() == startDate2.getUTCFullYear()){

        if(startDate1.getTime() == startDate2.getTime()){
            return true;
        } else if (startDate1.getTime() > startDate2.getTime() && startDate1.getTime() < endDate2.getTime()){
            return true;
        } else{
            return false;
        }
    } else {
        return false;
    }
};

//true for time overlapping
const timeOverlapDeterminer = (shifts: Array<Shift>) => {
    if (shifts){
        let result = false;
        shifts.forEach((shift,index)=>{
            let startDate = new Date(shift.startDate.date);
            let endDate = new Date(shift.endDate.date);
            for(let i = 0; i < shifts.length; i++){
                if(index != i) {
                    let startDate2 = new Date(shifts[i].startDate.date);
                    let endDate2 = new Date(shifts[i].endDate.date);
                    const day = timeOverlap(startDate,endDate,startDate2, endDate2);
                    if(day == true){
                        result = true;
                        return true;
                    }
                }
            }
        });
        if(result){
            return true;
        }
        return false;
    }
};

// TODO: Clean this up so it doesnt have an O(n^2) run time
export const doubleShiftMapper = (weekTimes: WeekTimes): doubleShift => {
    const doubleShiftObject: doubleShift = {
        monday: false,
        tuesday: false,
        wednesday: false,
        thursday: false,
        friday: false,
        saturday: false,
        sunday: false,
    };

    if(timeOverlapDeterminer(weekTimes.monday)){
        doubleShiftObject.monday = true;
    }

    if(timeOverlapDeterminer(weekTimes.tuesday)) {
        doubleShiftObject.tuesday = true;

    }

    if(timeOverlapDeterminer(weekTimes.wednesday)){
        doubleShiftObject.wednesday = true;
    }

    if(timeOverlapDeterminer(weekTimes.thursday)){
        doubleShiftObject.thursday = true;
    }

    if(timeOverlapDeterminer(weekTimes.friday)){
        doubleShiftObject.friday = true;
    }

    if(timeOverlapDeterminer(weekTimes.saturday)){
        doubleShiftObject.saturday = true;
    }

    if(timeOverlapDeterminer(weekTimes.sunday)){
        doubleShiftObject.sunday = true;
    }

    return doubleShiftObject;
};

export const timeSort = (shift1: Shift, shift2: Shift) => {
    const shift1StartTime = new Date(shift1.startDate.date);
    const shift2StartTime = new Date(shift2.startDate.date);

    if(shift1StartTime > shift2StartTime){
        return 1;
    } else if(shift1StartTime < shift2StartTime){
        return -1
    } else{
        return 0
    }
};


export const timeMapper = (shifts: Array<Shift>): WeekTimes => {

    const weekTimesObject: WeekTimes = {
        monday: [],
        tuesday: [],
        wednesday: [],
        thursday: [],
        friday: [],
        saturday: [],
        sunday: [],
        timeMap: {
            startTimes: [],
            endTimes: []
        }
    };

    shifts.forEach(shift =>{
        const shiftStartDate = new Date(shift.startDate.date);

        switch(shiftStartDate.getDay()){
            case 0:
                weekTimesObject.sunday.push(shift);
                break;
            case 1:
                weekTimesObject.monday.push(shift);
                break;
            case 2:
                weekTimesObject.tuesday.push(shift);
                break;
            case 3:
                weekTimesObject.wednesday.push(shift);
                break;
            case 4:
                weekTimesObject.thursday.push(shift);
                break;
            case 5:
                weekTimesObject.friday.push(shift);
                break;
            case 6:
                weekTimesObject.saturday.push(shift);
                break;
        }
    });

    weekTimesObject.sunday.sort(timeSort);
    weekTimesObject.monday.sort(timeSort);
    weekTimesObject.tuesday.sort(timeSort);
    weekTimesObject.wednesday.sort(timeSort);
    weekTimesObject.thursday.sort(timeSort);
    weekTimesObject.friday.sort(timeSort);
    weekTimesObject.saturday.sort(timeSort);
    return weekTimesObject;
};

export const formatTime = (date: Date) => {
    date = new Date(date);
    let ampm = 'AM';
    let minutes: string|number = 0;
    let hours = 0;
    if(date.getHours() > 13){
        ampm = 'PM';
        hours = date.getHours() - 12;
    } else if(date.getHours() === 13){
        hours = 1;
        ampm = 'PM'
    }else if (date.getHours() === 12){
        hours = 12;
        ampm = 'PM';
    }else{
        hours = date.getHours();
    }
    minutes = date.getMinutes();
    if(minutes === 0){
        minutes = '00'
    } else if (minutes < 10){
        minutes = '0'+ minutes;
    }
    return (`${hours}:${minutes} ${ampm}`);
};

export const formatDate = (date: Date) => {
    date = new Date(date);
    return `${parseMonth(date.getMonth())} ${date.getDate()}, ${date.getFullYear()}`;
};

export const parsePod =(podId, pods: Array<any>) => {
    let podName = '';
    pods.forEach(pod =>{
        if(pod.podId === podId){
            podName = pod.podName;
        }
    });
    return podName;
};

export const filterShiftsByPod = (podId, shifts: Array<Shift>) => {

    return shifts.filter((shift) => {
        return shift.podId === podId;
    });
};

export const filterShiftsByScon = (sconNetId: string, shifts: Array<Shift>) => {
    return shifts.filter((shift) => {
        return shift.sconNetId === sconNetId;
    });
};

export const filterShiftsByDay = (day: number, shifts: Array<Shift>) => {
    return shifts.filter ((shift) => {
        let startDay = (new Date(shift.startDate.date)).getDay();
        return startDay === day;
    });
};

export const determineSconHours = (shifts: Array<Shift>) => {
    let totalTime = 0;
    shifts.forEach((shift) =>{

       let startDay = new Date(shift.startDate.date);
       let endDay = new Date(shift.endDate.date);
       console.log("COMPARING: ");
       //@ts-ignore
       totalTime += ((((endDay - startDay)/1000)/60)/60);
        console.log('TOTAL TIME: '+totalTime);
    });
    return totalTime;
};

export const podMapper = (shifts: Array<Shift>) => {
    const weekTimesObject: WeekTimes = {
        monday: [],
        tuesday: [],
        wednesday: [],
        thursday: [],
        friday: [],
        saturday: [],
        sunday: [],
        timeMap: {
            startTimes: [],
            endTimes: []
        }
    };

    shifts.forEach(shift =>{

        switch(shift.podId){
            case 7:
                weekTimesObject.sunday.push(shift); // CJ
                break;
            case 4:
                weekTimesObject.monday.push(shift); //DSH
                break;
            case 1:
                weekTimesObject.tuesday.push(shift); //Lobo
                break;
            case 6:
                weekTimesObject.wednesday.push(shift); //ESCN
                break;
            case 5:
                weekTimesObject.thursday.push(shift); //ESCS
                break;
            case 2:
                weekTimesObject.friday.push(shift); // JCP
                break;
            case 3:
                weekTimesObject.saturday.push(shift); //Athletics
                break;
        }
    });

    weekTimesObject.sunday.sort(timeSort);
    weekTimesObject.monday.sort(timeSort);
    weekTimesObject.tuesday.sort(timeSort);
    weekTimesObject.wednesday.sort(timeSort);
    weekTimesObject.thursday.sort(timeSort);
    weekTimesObject.friday.sort(timeSort);
    weekTimesObject.saturday.sort(timeSort);
    return weekTimesObject;
};

export const doubleShiftMaker = (shifts: Array<Shift>) => {
    let returnObject = {
        slot1: [],
        slot2: [],
    };
    if (shifts){
        shifts.forEach((shift,index)=>{
            let startDate = new Date(shift.startDate.date);
            let endDate = new Date(shift.endDate.date);
            let status = false;
            for(let i = 0; i < returnObject.slot1.length; i++){
                if(shift.shiftId != returnObject.slot1[i].shiftId) {
                    let startDate2 = new Date(returnObject.slot1[i].startDate.date);
                    let endDate2 = new Date(returnObject.slot1[i].endDate.date);
                    const day = timeOverlap(startDate,endDate,startDate2, endDate2);
                    if(day == true){
                        status = true;
                    }
                }
            }
            if(status){
                returnObject.slot2.push(shift);
            } else{
                returnObject.slot1.push(shift);
            }
        });
    }

    returnObject.slot1.sort(timeSort);
    returnObject.slot2.sort(timeSort);

    return returnObject;
};

export function columnMapper(newShifts, doubleShifts: any, startTime, showScon, showPod, pods, draggable?:boolean|undefined){
    let shiftArray = [];
    if(doubleShifts.monday){
        let doubleShiftsMapped = doubleShiftMaker(newShifts.monday);
        shiftArray.push({
            id: 'monday1',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot1,
            startTime,
            showScon,
            showPod,
            pods
        });
        shiftArray.push({
            id: 'monday2',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot2,
            startTime,
            showScon,
            showPod,
            pods
        });
    } else{
        shiftArray.push({
            id: 'monday',
            doubleShift: false,
            shifts: newShifts.monday,
            startTime,
            showScon,
            showPod,
            pods,
        })
    }

    if(doubleShifts.tuesday){
        let doubleShiftsMapped = doubleShiftMaker(newShifts.tuesday);
        shiftArray.push({
            id: 'tuesday1',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot1,
            startTime,
            showScon,
            showPod,
            pods
        });
        shiftArray.push({
            id: 'tuesday2',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot2,
            startTime,
            showScon,
            showPod,
            pods
        });
    } else{
        shiftArray.push({
            id: 'tuesday',
            doubleShift: false,
            shifts: newShifts.tuesday,
            startTime,
            showScon,
            showPod,
            pods,
        })
    }

    if(doubleShifts.wednesday){
        let doubleShiftsMapped = doubleShiftMaker(newShifts.wednesday);
        shiftArray.push({
            id: 'wednesday1',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot1,
            startTime,
            showScon,
            showPod,
            pods
        });
        shiftArray.push({
            id: 'wednesday2',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot2,
            startTime,
            showScon,
            showPod,
            pods
        });
    } else{
        shiftArray.push({
            id: 'wednesday',
            doubleShift: false,
            shifts: newShifts.wednesday,
            startTime,
            showScon,
            showPod,
            pods,
        })
    }

    if(doubleShifts.thursday){
        let doubleShiftsMapped = doubleShiftMaker(newShifts.thursday);
        shiftArray.push({
            id: 'thursday1',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot1,
            startTime,
            showScon,
            showPod,
            pods
        });
        shiftArray.push({
            id: 'thursday2',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot2,
            startTime,
            showScon,
            showPod,
            pods
        });
    } else{
        shiftArray.push({
            id: 'thursday',
            doubleShift: false,
            shifts: newShifts.thursday,
            startTime,
            showScon,
            showPod,
            pods,
        })
    }

    if(doubleShifts.friday){
        let doubleShiftsMapped = doubleShiftMaker(newShifts.friday);
        shiftArray.push({
            id: 'friday1',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot1,
            startTime,
            showScon,
            showPod,
            pods
        });
        shiftArray.push({
            id: 'friday2',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot2,
            startTime,
            showScon,
            showPod,
            pods
        });
    } else{
        shiftArray.push({
            id: 'friday',
            doubleShift: false,
            shifts: newShifts.friday,
            startTime,
            showScon,
            showPod,
            pods,
        })
    }

    if(doubleShifts.saturday){
        let doubleShiftsMapped = doubleShiftMaker(newShifts.saturday);
        shiftArray.push({
            id: 'saturday1',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot1,
            startTime,
            showScon,
            showPod,
            pods
        });
        shiftArray.push({
            id: 'saturday2',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot2,
            startTime,
            showScon,
            showPod,
            pods
        });
    } else{
        shiftArray.push({
            id: 'saturday',
            doubleShift: false,
            shifts: newShifts.saturday,
            startTime,
            showScon,
            showPod,
            pods,
        })
    }

    if(doubleShifts.sunday){
        let doubleShiftsMapped = doubleShiftMaker(newShifts.sunday);
        shiftArray.push({
            id: 'sunday1',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot1,
            startTime,
            showScon,
            showPod,
            pods
        });
        shiftArray.push({
            id: 'sunday2',
            doubleShift: false,
            shifts: doubleShiftsMapped.slot2,
            startTime,
            showScon,
            showPod,
            pods
        });
    } else{
        shiftArray.push({
            id: 'sunday',
            doubleShift: false,
            shifts: newShifts.sunday,
            startTime,
            showScon,
            showPod,
            pods,
        })
    }
    if(!draggable){
        shiftArray = shiftArray.filter((column) => {
            return column.shifts.length > 0
        });
    }
    return shiftArray;
}

export function convertMS( milliseconds ) {
    let hour, minute, seconds;
    seconds = Math.floor(milliseconds / 1000);
    minute = Math.floor(seconds / 60);
    seconds = seconds % 60;
    hour = Math.floor(minute / 60);
    minute = minute % 60;
    hour = hour % 24;
    return {
        hour: hour,
        minute: minute,
        seconds: seconds
    };
}



