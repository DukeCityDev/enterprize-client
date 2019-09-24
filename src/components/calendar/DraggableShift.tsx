import * as React from "react";
import {formatTime, parsePod} from './CalendarUtils'
import {Shift} from "../../interfaces";

interface Props{
    shift: {
        shiftId: number,
        sconNetId: string,
        available: boolean,
        day: string,
        podId: number,
        startTime: string,
        endTime: string,
    }
    showScon: boolean;
    showPod: boolean;
    pods: Array<any>;
    double?: boolean|undefined;
}

interface State{

}

export class DraggableShift extends React.Component<Props,State>{

    constructor(props){
        super(props);
    }

    parseDay(day){
        switch (day){
            case 'Monday':
                return '09';
            case 'Tuesday':
                return '10';
            case 'Wednesday':
                return '11';
            case 'Thursday':
                return '12';
            case 'Friday':
                return '13';
            case 'Saturday':
                return '14';
            case 'Sunday':
                return '15';
            default: // defaults to Monday
                return '09';
        }
    }

    render(){
        const shiftColor = this.props.shift.available ? 'available-shift' : 'normal-shift';
        const startDate = new Date(`2019-09-${this.parseDay(this.props.shift.day)}T${this.props.shift.startTime}:00-06:00`);
        const endDate = new Date(`2019-09-${this.parseDay(this.props.shift.day)}T${this.props.shift.endTime}:00-06:00`);
        let height = (endDate.getTime() - startDate.getTime()) / (1000*60);

        return (
            <div draggable={true} className={`draggable-shift ${shiftColor}}`} style={{height: height}}>
                <h4>{formatTime(startDate)}</h4>
                <h4>{this.props.shift.sconNetId}</h4>
                <h4>{parsePod(this.props.shift.podId, this.props.pods)}</h4>
                <h4>{formatTime(endDate)}</h4>
            </div>
        );
    }
}
