import * as React from "react";
import {bindActionCreators} from "redux";
import {connect} from "react-redux";
import {getAllPods, getScon, getShiftsByShiftPlanName} from "../actions";
import Navigation from "./navigation/Navigation"
import SideMenu from "./navigation/SideMenu";
import Calendar from "./calendar/Calendar";
import {Scon, Shift} from "../interfaces";
import {filterShiftsByPod} from "./calendar/CalendarUtils";
import TimePicker from 'react-time-picker';
import {DraggableShift} from "./calendar/DraggableShift";
import DraggableCalendar from "./calendar/DraggableCalendar";

interface State{
    sideMenuOn : boolean,
    currentPod: {
        podName: string;
        podId: number;
    }
    schedule: Array<Shift>,
    focusShiftId: number,
    focusSconNetId: string,
    focusAvailable: boolean,
    focusDay: string,
    focusPodId: number,
    focusStartTime: string,
    focusEndTime: string,
}

interface Props{
    scon : Scon;
    pods: Array<any>
}


class MakeSchedule extends React.Component<Props,State>{
    constructor(props){
        super(props);
        let date = new Date();
        //@ts-ignore
        this.state={
            sideMenuOn : false,
            schedule: [],
            currentPod: {
                podName: "Lobo",
                podId: 1,
            },

            focusShiftId: -1,
            focusSconNetId: 'Empty',
            focusAvailable: true,
            focusDay: '',
            focusPodId: 1,
            focusStartTime: '',
            focusEndTime: '',
        }
    }

    changeFocusDayAndInsert(day: string){
        let numDay = 1;
        switch(day){
            case 'sunday':
                numDay = 0;
                break;
            case 'monday':
                numDay = 1;
                break;
            case 'tuesday':
                numDay = 2;
                break;
            case 'wednesday':
                numDay = 3;
                break;
            case 'thursday':
                numDay = 4;
                break;
            case 'friday':
                numDay = 5;
                break;
            case 'saturday':
                numDay = 6;
                break;
        }

        let newSchedule = this.state.schedule;
        let newStartDay = new Date();
        let newEndDay = new Date('')


        newSchedule.push({
            shiftId: -1,
            sconNetId: 'Empty',
            available: true,
            day: '',
            podId: 1,
            startTime: '',
            endTime: '',
        });

        this.setState({focusDay: day});
    }

    changeStartTime(time){
        console.log(time);
        this.setState({focusStartTime: time});
    }

    changeEndTime(time){
        this.setState({focusEndTime: time});
    }

    componentWillMount(){
    }

    handleMenuClick = ()=>{
        this.setState({sideMenuOn : !(this.state.sideMenuOn)});
    };

    podSwitcher(direction: string) {
        if (direction === "forward"){
            switch (this.state.currentPod.podId) {
                case 1 :
                    this.setState({currentPod: {podName: "JCP", podId: 2}, focusPodId: 2});
                    break;
                case 2 :
                    this.setState({currentPod: {podName: "Athletics", podId: 3}, focusPodId: 3});
                    break;
                case 3 :
                    this.setState({currentPod: {podName: "DSH", podId: 4}, focusPodId: 4});
                    break;
                case 4 :
                    this.setState({currentPod: {podName: "ESCS", podId: 5}, focusPodId: 5});
                    break;
                case 5 :
                    this.setState({currentPod: {podName: "ESCN", podId: 6}, focusPodId: 6});
                    break;
                case 6 :
                    this.setState({currentPod: {podName: "Lobo", podId: 1}, focusPodId: 1});
                    break;
            }
        } else{
            switch (this.state.currentPod.podId) {
                case 1 :
                    this.setState({currentPod: {podName: "ESCN", podId: 6}, focusPodId: 6});
                    break;
                case 2 :
                    this.setState({currentPod: {podName: "Lobo", podId: 1}, focusPodId: 1});
                    break;
                case 3 :
                    this.setState({currentPod: {podName: "JCP", podId: 2}, focusPodId: 2});
                    break;
                case 4 :
                    this.setState({currentPod: {podName: "Athletics", podId: 3}, focusPodId: 3});
                    break;
                case 5 :
                    this.setState({currentPod: {podName: "DSH", podId: 4}, focusPodId: 4});
                    break;
                case 6 :
                    this.setState({currentPod: {podName: "ESCS", podId: 5}, focusPodId: 5});
                    break;
            }
        }
    }

    changeFormStringValue = (event) =>{
        //@ts-ignore
        this.setState({[event.target.name] : event.target.value});
    };

    render(){
        const {sideMenuOn} = this.state;
        const shifts = filterShiftsByPod(this.state.currentPod.podId, this.state.schedule);
        return (
            <div>
                <Navigation scon={this.props.scon} sectionName={"Make Schedule"} handleMenuClick={this.handleMenuClick.bind(this)}/>
                <SideMenu sideMenuOn={this.state.sideMenuOn}/>
                <div style={{width: '100%', textAlign: 'center'}}>
                    <h1>{this.state.currentPod.podName} Pod</h1>
                </div>
                <div id={'flex-container'}>
                    <form id={'make-schedule-form'}>
                        <label htmlFor={"netId"}>Net Id</label>
                        <input className={'make'} name={'focusSconNetId'} type={'text'} value={this.state.focusSconNetId} onChange={(event) => {this.changeFormStringValue(event)}} />
                        <label htmlFor={"available"}>Available</label>
                        <input className={'make'} checked={this.state.focusAvailable} name={'available'} type={'checkbox'} onChange={(event) => {this.setState({focusAvailable: !this.state.focusAvailable})}}/>
                        <br />
                        <div className={'timePicker'}><TimePicker onChange={this.changeStartTime.bind(this)} value={this.state.focusStartTime}/></div>
                        <div className={'timePicker'}><TimePicker onChange={this.changeEndTime.bind(this)} value={this.state.focusEndTime}/></div>
                    </form>
                    <div id={'make-shift-container'}>
                        <DraggableShift shift={{
                            shiftId: this.state.focusShiftId,
                            sconNetId: this.state.focusSconNetId,
                            available: this.state.focusAvailable,
                            day: this.state.focusDay,
                            podId: this.state.focusPodId,
                            startTime: this.state.focusStartTime,
                            endTime: this.state.focusEndTime,

                        }} showScon={true} showPod={true} pods={this.props.pods}/>
                    </div>
                </div>
                <DraggableCalendar switcher={this.podSwitcher.bind(this)} switch={true} showScon={true} showPod={false} shifts = {shifts} pods={this.props.pods}/>
            </div>
        )
    }
}

function mapStateToProps(state){
    return {
        scon: state.scon,
        pods: state.pods
    }
}

const mapDispatchToProps = (dispatch)=>{
    return bindActionCreators({getScon,getAllPods},dispatch);
};

export default connect(mapStateToProps, null)(MakeSchedule);