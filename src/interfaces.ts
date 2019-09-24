export interface Scon {
    adminStatus : boolean,
    email : string,
    firstName : string,
    lastName : string,
    middleInitial : string,
    netId : string,
    sconId : number,
    startDate : Date,
    phoneNumber: string|number;
}

export interface Shift{
    shiftId : number,
    available : boolean,
    startDate :  {
        date : Date;
    }
    endDate : {
        date: Date;
    },
    podId : number,
    sconNetId: string,
    shiftPlanName: string
    showStartDate?: boolean;
    showEndDate?: boolean;
    priorEndDate?: any;
}

export interface doubleShift{
    monday: boolean;
    tuesday: boolean;
    wednesday: boolean;
    thursday: boolean;
    friday: boolean;
    saturday: boolean;
    sunday: boolean;
}

export interface WeekTimes{
    monday: Array<Shift>;
    tuesday: Array<Shift>;
    wednesday: Array<Shift>;
    thursday: Array<Shift>;
    friday: Array<Shift>;
    saturday: Array<Shift>;
    sunday: Array<Shift>;
    timeMap: TimeMap;
}

export interface TimeMap {
    startTimes: Array<Date>;
    endTimes: Array<Date>
}