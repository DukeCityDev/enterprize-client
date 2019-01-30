import * as React from "react";
import {Shift} from "../../interfaces";
import {doubleShiftMapper} from "./CalendarUtils";

interface Props {
    shifts : Array<Shift>
}

interface State {
}

export default class CalendarDesktop extends React.Component<Props,State> {
    constructor(props){
        super(props);

    }

    componentWillReceiveProps(props){
       let doubleShift = doubleShiftMapper(this.props.shifts);
        console.log (doubleShift);
    }

    render(){
        const shifts = this.props;

        return (
            <table id={"calendar-full-size"}>
                <thead>
                    <tr id={"calendar-header-row"}>
                        <th className={"calendar-header-cell"}>Monday</th>
                        <th className={"calendar-header-cell"}>Tuesday</th>
                        <th className={"calendar-header-cell"}>Wednesday</th>
                        <th className={"calendar-header-cell"}>Thursday</th>
                        <th className={"calendar-header-cell"}>Friday</th>
                        <th className={"calendar-header-cell"}>Saturday</th>
                        <th className={"calendar-header-cell"}>Sunday</th>
                    </tr>
                </thead>
                <tbody className={"calendar-body"}>

                </tbody>
            </table>
        );
    }
}