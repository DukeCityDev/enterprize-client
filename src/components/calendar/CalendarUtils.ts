import {doubleShift, Shift, WeekTimes} from "../../interfaces";


const timeOverlap = (startDate1, endDate1, startDate2,endDate2)=>{

    if(startDate1.getDate() == startDate2.getDate() && startDate1.getMonth() == startDate2.getMonth() && startDate1.getUTCFullYear() == startDate2.getUTCFullYear()){

        if(startDate1.getTime() == startDate2.getTime()){
            return startDate1.getDay();
        } else if (startDate1.getTime() > startDate2.getTime() && startDate1.getTime() < endDate2.getTime()){
            console.log("HIT2");
            console.log(startDate1.getDay());
            return startDate1.getDay();
        } else{
            return -1;
        }
    } else {
        return -1;
    }
};

// TODO: Clean this up so it doesnt have an O(n^2) run time
export const doubleShiftMapper = (shifts: Array<Shift>): doubleShift => {
    const doubleShiftObject: doubleShift = {
        monday: false,
        tuesday: false,
        wednesday: false,
        thursday: false,
        friday: false,
        saturday: false,
        sunday: false,
    };

    shifts.forEach((shift,index)=>{
        let startDate = new Date(shift.startDate.date);
        let endDate = new Date(shift.endDate.date);
        for(let i = 0; i < shifts.length; i++){
            if(index != i) {
                let startDate2 = new Date(shifts[i].startDate.date);
                let endDate2 = new Date(shifts[i].endDate.date);
                const day = timeOverlap(startDate,endDate,startDate2, endDate2);
                switch(day){
                    case 0:
                        doubleShiftObject.sunday = true;
                        break;
                    case 1:
                        doubleShiftObject.monday = true;
                        break;
                    case 2:
                        doubleShiftObject.tuesday = true;
                        break;
                    case 3:
                        doubleShiftObject.wednesday = true;
                        break;
                    case 4:
                        doubleShiftObject.thursday = true;
                        break;
                    case 5:
                        console.log("HIT 3");
                        doubleShiftObject.friday = true;
                        break;
                    case 6:
                        doubleShiftObject.saturday = true;
                        break;
                }
            }
        }
    });
    return doubleShiftObject;
}

const timeSort = (shift1: Shift, shift2: Shift) => {
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

    shifts.forEach(shift=>{
        const shiftStartDate = new Date(shift.startDate.date);
        const shiftEndDate = new Date(shift.endDate.date);

        weekTimesObject.timeMap.startTimes.push(shiftStartDate);
        weekTimesObject.timeMap.startTimes.push(shiftEndDate);

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
