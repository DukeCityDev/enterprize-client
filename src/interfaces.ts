export interface Scon {
    adminStatus : boolean,
    email : string,
    firstName : string,
    lastName : string,
    middleInitial : string,
    netId : number,
    sconId : number,
    startDate : Date
}

export interface Shift{
    shiftId : number,
    available : boolean|number,
    startDate :  {
        date : Date;
    }
    endDate : {
        date: Date;
    },
    podId : number,
    sconNetId: string,
    shiftPlanName: string
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