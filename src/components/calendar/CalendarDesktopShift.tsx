import * as React from "react";
import {formatTime, parsePod} from './CalendarUtils'
import {Shift} from "../../interfaces";

interface Props{
    shift: Shift,
    showScon: boolean;
    showPod: boolean;
    pods: Array<any>;
    double?: boolean|undefined;
    modelAction(open:boolean, shift: Shift)
}

interface State{

}

export class CalendarDesktopShift extends React.Component<Props,State>{

    constructor(props){
        super(props);
    }

    render(){
        const shiftColor = this.props.shift.available ? 'available-shift' : 'normal-shift';
        const startDate = new Date(this.props.shift.startDate.date);
        const endDate = new Date(this.props.shift.endDate.date);
        const priorEndDate = new Date(this.props.shift.priorEndDate);
        let topMargin = (startDate.getTime() - priorEndDate.getTime()) / (1000*60);
        let height = (endDate.getTime() - startDate.getTime()) / (1000*60);

        return (
            <div onClick={(event) => this.props.modelAction(true, this.props.shift)} className={`desktop-shift ${shiftColor} ${this.props.double ? 'calendar-full-size-half-column': ''}`} style={{marginTop: topMargin , height: height}}>
                {this.props.shift.showStartDate ? <h4>{formatTime(this.props.shift.startDate.date)}</h4>: null}
                {this.props.showScon ? <h4>{this.props.shift.sconNetId}</h4> : null}
                {this.props.showPod ? <h4>{parsePod(this.props.shift.podId, this.props.pods)}</h4> : null}
                {this.props.shift.showEndDate ? <h4>{formatTime(this.props.shift.endDate.date)}</h4>: null}
            </div>
        );
    }
}
