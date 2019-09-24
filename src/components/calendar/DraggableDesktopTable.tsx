import * as React from "react";
import {doubleShift, Shift, WeekTimes} from "../../interfaces";
import {columnMapper, doubleShiftMaker, doubleShiftMapper, podMapper, timeMapper, timeSort} from "./CalendarUtils";
import {CalendarDesktopColumn} from "./CalendarDesktopColumn";
import CalendarDesktopHeader from "./CalendarDesktopHeader";
import {CalendarDesktopShift} from "./CalendarDesktopShift";
import {DraggableDesktopColumn} from "./DraggableDesktopColumn";

interface Props{
    showTime: boolean;
    shifts: Array<Shift>;
    showPod: boolean;
    showScon: boolean;
    pods: Array<any>;
    showDays?:boolean|undefined;
    modalAction(open: boolean, shift: Shift);
}

interface State{
}

export default class DraggableDesktopTable extends React.Component<Props,State> {

    constructor (props) {
        super(props);

        this.state = {
        }
    }

    render(){
        const orderedShifts = this.props.shifts.sort(timeSort);
        let startTime = new Date("June 29, 1994 08:00:00");
        if(orderedShifts.length > 0){
            startTime = orderedShifts[0].startDate.date;
        }
        let newShifts;
        if(this.props.showDays){
            // we want to organize shifts into days here
            newShifts = podMapper(this.props.shifts);
        } else {
            // we want to organize shifts into days here
            newShifts = timeMapper(this.props.shifts);
        }
        // we also want to organize days in which shifts are double
        let db = doubleShiftMapper(newShifts);

        const shifts = columnMapper(newShifts, db, startTime, this.props.showScon, this.props.showPod, this.props.pods, true);
        console.log(shifts);

        return (
            <table id={"calendar-full-size"}>
                <thead id={'calendar-header-row'}>
                <CalendarDesktopHeader dragMode={true} showDays={this.props.showDays} doubleShifts={db} showTime={false} weekTimes={newShifts} />
                </thead>

                <tbody>
                <tr className={'table'}>
                    {shifts.map((shiftColumn) => {
                        return <DraggableDesktopColumn id={shiftColumn.id} modelAction={this.props.modalAction} shifts={shiftColumn.shifts} startTime={shiftColumn.startTime} showPod={shiftColumn.showPod} showScon={shiftColumn.showScon} pods={shiftColumn.pods} />
                    })}
                </tr>
                </tbody>
            </table>
        )
    }
}