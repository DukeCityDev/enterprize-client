import * as React from "react";
import {doubleShift, WeekTimes} from "../../interfaces";

interface Props{
    doubleShifts?: doubleShift;
    showTime: boolean;
    weekTimes: WeekTimes;
    showDays?: boolean;
    dragMode?: boolean;
}

interface State{

}

export default class CalendarDesktopHeader extends React.Component<Props,State>{

    constructor(props){
        super(props);
    }

    render(){
        if(this.props.dragMode){
            return (
                <tr id={"calendar-header-row"}>
                    <th colSpan={this.props.doubleShifts.monday ? 2 : 1} className={"calendar-header-cell"}>Monday</th>
                    <th colSpan={this.props.doubleShifts.tuesday ? 2 : 1} className={"calendar-header-cell"}>Tuesday</th>
                    <th colSpan={this.props.doubleShifts.wednesday ? 2 : 1} className={"calendar-header-cell"}>Wednesday</th>
                    <th colSpan={this.props.doubleShifts.thursday ? 2 : 1} className={"calendar-header-cell"}>Thursday</th>
                    <th colSpan={this.props.doubleShifts.friday ? 2 : 1} className={"calendar-header-cell"}>Friday</th>
                    <th colSpan={this.props.doubleShifts.saturday ? 2 : 1} className={"calendar-header-cell"}>Saturday</th>
                    <th colSpan={this.props.doubleShifts.sunday ? 2 : 1} className={"calendar-header-cell"}>Sunday</th>
                </tr>)
        } else if(!this.props.showDays){
            return (
                <tr id={"calendar-header-row"}>
                    {this.props.showTime ? <th colSpan={1}> </th>: null}
                    {this.props.weekTimes.monday.length > 0 ? <th colSpan={this.props.doubleShifts.monday ? 2 : 1} className={"calendar-header-cell"}>Monday</th>: null}
                    {this.props.weekTimes.tuesday.length > 0 ?<th colSpan={this.props.doubleShifts.tuesday ? 2 : 1} className={"calendar-header-cell"}>Tuesday</th>: null}
                    {this.props.weekTimes.wednesday.length > 0 ?<th colSpan={this.props.doubleShifts.wednesday ? 2 : 1} className={"calendar-header-cell"}>Wednesday</th>: null}
                    {this.props.weekTimes.thursday.length > 0 ?<th colSpan={this.props.doubleShifts.thursday ? 2 : 1} className={"calendar-header-cell"}>Thursday</th>: null}
                    {this.props.weekTimes.friday.length > 0 ? <th colSpan={this.props.doubleShifts.friday ? 2 : 1} className={"calendar-header-cell"}>Friday</th>: null}
                    {this.props.weekTimes.saturday.length > 0 ? <th colSpan={this.props.doubleShifts.saturday ? 2 : 1} className={"calendar-header-cell"}>Saturday</th>: null}
                    {this.props.weekTimes.sunday.length > 0 ? <th colSpan={this.props.doubleShifts.sunday ? 2 : 1} className={"calendar-header-cell"}>Sunday</th>: null}
                </tr>)
        }
        return (
            <tr id={"calendar-header-row"}>
                {this.props.weekTimes.monday.length > 0 ? <th colSpan ={this.props.doubleShifts.monday ? 2 : 1} className={"calendar-header-cell"}>DSH</th>: null}
                {this.props.weekTimes.tuesday.length > 0 ? <th colSpan={this.props.doubleShifts.tuesday ? 2 : 1} className={"calendar-header-cell"}>Lobo</th>: null}
                {this.props.weekTimes.wednesday.length > 0 ? <th colSpan={this.props.doubleShifts.wednesday ? 2 : 1} className={"calendar-header-cell"}>ESCN</th>: null}
                {this.props.weekTimes.thursday.length > 0 ? <th colSpan={this.props.doubleShifts.thursday ? 2 : 1} className={"calendar-header-cell"}>ESCS</th>: null}
                {this.props.weekTimes.friday.length > 0 ? <th colSpan={this.props.doubleShifts.friday ? 2 : 1} className={"calendar-header-cell"}>JCP</th>: null}
                {this.props.weekTimes.saturday.length > 0 ? <th colSpan={this.props.doubleShifts.saturday ? 2 : 1} className={"calendar-header-cell"}>Athletics</th>: null}
                {this.props.weekTimes.sunday.length > 0 ? <th colSpan={this.props.doubleShifts.sunday ? 2 : 1} className={"calendar-header-cell"}>CJ</th>: null}
            </tr>)
    }
}