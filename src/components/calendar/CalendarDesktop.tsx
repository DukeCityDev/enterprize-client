import * as React from "react";
import {Shift, doubleShift} from "../../interfaces";
import {doubleShiftMapper} from "./CalendarUtils";
import CalendarDesktopHeader from "./CalendarDesktopHeader";
import CalendarDesktopBody from "./CalendarDesktopBody";

interface Props {
    shifts : Array<Shift>
}

interface State {
    doubleShifts: doubleShift;
}

export default class CalendarDesktop extends React.Component<Props,State> {
    constructor(props){
        super(props);
        this.state = {
            doubleShifts: {
                sunday: false,
                monday: false,
                tuesday: false,
                wednesday: false,
                thursday: false,
                friday: false,
                saturday: false
            }
        }
    }

    componentWillReceiveProps(props){
       let doubleShifts = doubleShiftMapper(this.props.shifts);
       this.setState({doubleShifts});
    }

    render(){
        const shifts = this.props;

        return (
            <table id={"calendar-full-size"}>
                <thead>
                    <CalendarDesktopHeader showTime={true} doubleShifts={this.state.doubleShifts}/>
                </thead>
                <CalendarDesktopBody showTime={true} doubleShifts={this.state.doubleShifts} />
            </table>
        );
    }
}