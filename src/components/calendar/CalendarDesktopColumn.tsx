import * as React from "react";
import {doubleShift, Shift, WeekTimes} from "../../interfaces";
import Calendar from "./Calendar";
import {CalendarDesktopShift} from "./CalendarDesktopShift";
import {doubleShiftMaker, doubleShiftMapper} from "./CalendarUtils";

interface Props{
    shifts: Array<any>
    startTime: Date;
    showPod: boolean;
    showScon: boolean;
    pods: Array<any>;
    id?: string;
    modelAction(open: boolean, shift: Shift);
}

interface State{

}

export class CalendarDesktopColumn extends React.Component<Props,State>{

    constructor(props){
        super(props);
    }

    render(){
       let finalIndex = 0;

       if(this.props.shifts){
           finalIndex = this.props.shifts.length -1;
       }
       let shifts = this.props.shifts;
       shifts.forEach((shift, index) => {
           if(index === 0){
               const startTime = new Date(this.props.startTime);
               let priorEndDate = new Date(shift.startDate.date);
               priorEndDate.setHours(startTime.getHours());
               priorEndDate.setMinutes(startTime.getMinutes());
               shift.priorEndDate = priorEndDate;
               shift.showStartDate = true;
               shift.showEndDate = false;
           } else if(index === finalIndex){
               shift.priorEndDate = shifts[index - 1].endDate.date;
               shift.showStartDate = true;
               shift.showEndDate = true;

           } else {
               shift.priorEndDate = shifts[index - 1].endDate.date;
               shift.showStartDate = true;
               shift.showEndDate = false;
           }
       });

       shifts =  this.props.shifts.map((shift) => {
           return <CalendarDesktopShift modelAction={this.props.modelAction} key={shift.shiftId} shift={shift} showPod={this.props.showPod} showScon={this.props.showScon} pods={this.props.pods} />
       });

        return (
           <td id={this.props.id} colSpan={1} className={"calendar-full-size-column"} style={{padding: 0}}>
               {shifts}
           </td>
        );
    }
}
