import * as React from "react";
import {doubleShift, Shift, WeekTimes} from "../../interfaces";
import {timeMapper} from "./CalendarUtils";

interface Props{
    doubleShifts: doubleShift;
    showTime: boolean;
    shifts: Array<Shift>;
}

interface State{
    shifts: WeekTimes;
}

export default class CalendarDesktopBody extends React.Component<Props,State> {

    constructor (props) {
        super(props);

        this.state = {
            shifts: {
                sunday: [],
                monday: [],
                tuesday: [],
                wednesday: [],
                thursday: [],
                friday: [],
                saturday: [],
                timeMap: {
                    startTimes: [],
                    endTimes: []
                }
            }
        }
    }

    componentWillReceiveProps(props){
        let weekTimes = timeMapper(this.props.shifts);
        this.setState({shifts : weekTimes});
    }


    render(){
        console.log(this.state.shifts);
        return (
            <tbody>

            </tbody>
        )
    }
}