import * as React from "react";
import {Shift} from "../../interfaces";
import CalendarDesktop from "./CalendarDesktop";

interface Props{
    shifts : Array<Shift>
}

interface State{

}

export default class Calendar extends React.Component<Props,State>{
    constructor(props){
        super(props);
    }

    render(){
        return (
            <div id={"calendar-container"}>
                <CalendarDesktop shifts={this.props.shifts} />
            </div>
        )
    }
}