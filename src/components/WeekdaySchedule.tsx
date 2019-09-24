import * as React from "react";
import {bindActionCreators} from "redux";
import {connect} from "react-redux";
import {getAllPods, getScon, getShiftsByShiftPlanName} from "../actions";
import Navigation from "./navigation/Navigation"
import SideMenu from "./navigation/SideMenu";
import Calendar from "./calendar/Calendar";
import {Scon, Shift} from "../interfaces";
import {filterShiftsByDay, filterShiftsByPod} from "./calendar/CalendarUtils";

interface State{
    sideMenuOn : boolean,
    currentDay: {
        dayName: string;
        day: number;
    }
}

interface Props{
    scon : Scon;
    schedule : Array<Shift>;
    pods: Array<any>
}


class WeekdaySchedule extends React.Component<Props,State>{
    constructor(props){
        super(props);

        //@ts-ignore
        this.state={
            sideMenuOn : false,
            currentDay: {
                dayName: "Lobo",
                day: 1,
            }
        }
    }


    componentWillMount(){
    }

    handleMenuClick = ()=>{
        this.setState({sideMenuOn : !(this.state.sideMenuOn)});
    };

    daySwitcher(direction: string) {
        if (direction === "forward"){
            switch (this.state.currentDay.day) {
                case 0 :
                    this.setState({currentDay: {dayName: "Monday", day: 1}});
                    break;
                case 1 :
                    this.setState({currentDay: {dayName: "Tuesday", day: 2}});
                    break;
                case 2 :
                    this.setState({currentDay: {dayName: "Wednesday", day: 3}});
                    break;
                case 3 :
                    this.setState({currentDay: {dayName: "Thursday", day: 4}});
                    break;
                case 4 :
                    this.setState({currentDay: {dayName: "Friday", day: 5}});
                    break;
                case 5 :
                    this.setState({currentDay: {dayName: "Saturday", day: 6}});
                    break;
                case 6 :
                    this.setState({currentDay: {dayName: "Sunday", day: 0}});
                    break;
            }
        } else{
            switch (this.state.currentDay.day) {
                case 0 :
                    this.setState({currentDay: {dayName: "Saturday", day: 6}});
                    break;
                case 1 :
                    this.setState({currentDay: {dayName: "Sunday", day: 0}});
                    break;
                case 2 :
                    this.setState({currentDay: {dayName: "Monday", day: 1}});
                    break;
                case 3 :
                    this.setState({currentDay: {dayName: "Tuesday", day: 2}});
                    break;
                case 4 :
                    this.setState({currentDay: {dayName: "Wednesday", day: 3}});
                    break;
                case 5 :
                    this.setState({currentDay: {dayName: "Thursday", day: 4}});
                    break;
                case 6 :
                    this.setState({currentDay: {dayName: "Friday", day: 5}});
                    break;
            }
        }
    }

    render(){
        const {sideMenuOn} = this.state;
        const shifts = filterShiftsByDay(this.state.currentDay.day, this.props.schedule);

        return (
            <div>
                <Navigation scon={this.props.scon} sectionName={"Weekday Schedule"} handleMenuClick={this.handleMenuClick.bind(this)}/>
                <SideMenu sideMenuOn={this.state.sideMenuOn}/>
                <div style={{width: '100%', textAlign: 'center'}}>
                    <h1>{this.state.currentDay.dayName} Schedule </h1>
                </div>
                <Calendar showDays={true} switcher={this.daySwitcher.bind(this)} switch={true} showScon={true} showPod={false} shifts = {shifts} pods={this.props.pods}/>
            </div>
        )
    }
}

function mapStateToProps(state){
    return {
        scon: state.scon,
        schedule : state.schedule,
        pods: state.pods
    }
}

const mapDispatchToProps = (dispatch)=>{
    return bindActionCreators({getScon,getShiftsByShiftPlanName,getAllPods},dispatch);
};

export default connect(mapStateToProps, null)(WeekdaySchedule);