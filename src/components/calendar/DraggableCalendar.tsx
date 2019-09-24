import * as React from "react";
import {Shift} from "../../interfaces";
import CalendarDesktopTable from "./CalendarDesktopTable";
import CalendarModal from "./CalendarModal";
import DraggableDesktopTable from "./DraggableDesktopTable";

interface Props{
    shifts : Array<Shift>,
    pods: Array<any>,
    showScon: boolean;
    showPod: boolean;
    switch?: boolean|undefined;
    switcher?: (direction: string) => any| undefined;
    showDays?: boolean|undefined;
}

interface State{
    modalOpen: boolean;
    modalShift: Shift|null|undefined;
}

export default class DraggableCalendar extends React.Component<Props,State>{
    constructor(props){
        super(props);
        this.state = {
            modalOpen: false,
            modalShift: null,
        };
    }

    shiftModel = (open: boolean, shift: Shift) => {
        if(open){
            this.setState({modalOpen: true, modalShift: shift});
        } else{
            this.setState({modalOpen: false, modalShift:shift});
        }
    };

    render(){
        return (
            <div id={"calendar-container"}>
                {this.state.modalOpen ? <CalendarModal pods={this.props.pods} modelAction={this.shiftModel.bind(this)} shift={this.state.modalShift} /> : null}
                { this.props.switch ? <h1 style={{alignSelf: "center", cursor:"pointer", fontSize:64, marginRight: 10}} onClick={() => this.props.switcher("backward")}> {'<'} </h1>: null}

                <DraggableDesktopTable modalAction={this.shiftModel.bind(this)} showDays={this.props.showDays} showTime={false} shifts={this.props.shifts} showScon={this.props.showScon} showPod={this.props.showPod} pods={this.props.pods}/>
                { this.props.switch ? <h1 style={{alignSelf: "center", cursor:"pointer", fontSize:64, marginLeft: 10}} onClick={() => this.props.switcher("forward")}> {'>'} </h1>: null}
            </div>
        )
    }
}