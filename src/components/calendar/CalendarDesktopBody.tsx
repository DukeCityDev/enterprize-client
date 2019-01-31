import * as React from "react";
import {doubleShift} from "../../interfaces";

interface Props{
    doubleShifts: doubleShift;
    showTime: boolean;
}

interface State{

}

export default class CalendarDesktopBody extends React.Component<Props,State> {

    constructor (props) {
        super(props);
    }

    render(){
        return (
            <tbody>

            </tbody>
        )
    }
}