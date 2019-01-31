import * as React from "react";
import {doubleShift} from "../../interfaces";

interface Props{
    doubleShifts: doubleShift;
    showTime: boolean;
}

interface State{

}

export default class CalendarDesktopHeader extends React.Component<Props,State>{

    constructor(props){
        super(props);
    }


    render(){
        return (
            <tr id={"calendar-header-row"}>
                {this.props.showTime ? <th colSpan={1}> </th>: null}
                <th colSpan={this.props.doubleShifts.monday ? 2 : 1} className={"calendar-header-cell"}>Monday</th>
                <th colSpan={this.props.doubleShifts.tuesday ? 2 : 1} className={"calendar-header-cell"}>Tuesday</th>
                <th colSpan={this.props.doubleShifts.wednesday ? 2 : 1} className={"calendar-header-cell"}>Wednesday</th>
                <th colSpan={this.props.doubleShifts.thursday ? 2 : 1} className={"calendar-header-cell"}>Thursday</th>
                <th colSpan={this.props.doubleShifts.friday ? 2 : 1} className={"calendar-header-cell"}>Friday</th>
                <th colSpan={this.props.doubleShifts.saturday ? 2 : 1} className={"calendar-header-cell"}>Saturday</th>
                <th colSpan={this.props.doubleShifts.sunday ? 2 : 1} className={"calendar-header-cell"}>Sunday</th>
            </tr>)
    }
}