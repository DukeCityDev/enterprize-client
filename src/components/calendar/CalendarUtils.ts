import {doubleShift, Shift} from "../../interfaces";


const timeOverlap = (startDate1, endDate1, startDate2,endDate2)=>{

};

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
        let startDate = shift.startDate.date;
        let endDate = shift.endDate.date;
        for(let i = 0; i < shifts.length; i++){
            if(index != i) {
                timeOverlap(startDate,endDate,shifts[i].startDate.date,shifts[i].endDate.date);
            }
        }
    });




    return doubleShiftObject;
}
