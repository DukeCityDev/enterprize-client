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
    startDate : string,
    endDateS : string,
    podId : number,
    sconNetId: string,
    shiftPlanName: string

}