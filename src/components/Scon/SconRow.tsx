import {Scon, Shift} from "../../interfaces";
import * as React from "react";
import {convertMS, determineSconHours} from "../calendar/CalendarUtils";

interface TableState{
    sideMenuOn : boolean
}

interface TableProps{
    scon : Scon;
    handleRowClick(open: boolean,scon?: Scon);
    shifts: Array<Shift>;
}

export class SconRow extends React.Component<TableProps, TableState> {
    constructor(props) {
        super(props);
        //@ts-ignore
        this.state = {
            sideMenuOn: false
        }
    }

    showHours = (shifts: Array<Shift>) => {
        return determineSconHours(shifts);
    };

    render(){
        return (
            <tr onClick={(event)=>this.props.handleRowClick(true, this.props.scon)}>
                <td>{this.props.scon.netId}</td>
                <td>{this.props.scon.firstName}</td>
                <td>{this.props.scon.lastName}</td>
                <td>{this.props.scon.email}</td>
                <td>{this.props.scon.phoneNumber}</td>
                <td>{this.props.scon.adminStatus ? <h5 className={"admin-badge"}>Admin</h5>: null}</td>
                <td>{this.showHours(this.props.shifts)}</td>
            </tr>
        )
    }

}

