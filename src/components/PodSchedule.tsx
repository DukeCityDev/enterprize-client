import * as React from "react";
import {bindActionCreators} from "redux";
import {connect} from "react-redux";
import {getAllPods, getScon, getShiftsByShiftPlanName} from "../actions";
import Navigation from "./navigation/Navigation"
import SideMenu from "./navigation/SideMenu";
import Calendar from "./calendar/Calendar";
import {Scon, Shift} from "../interfaces";
import {filterShiftsByPod} from "./calendar/CalendarUtils";

interface State{
    sideMenuOn : boolean,
    currentPod: {
        podName: string;
        podId: number;
    }
}

interface Props{
    scon : Scon;
    schedule : Array<Shift>;
    pods: Array<any>
}


class PodSchedule extends React.Component<Props,State>{
    constructor(props){
        super(props);
        //@ts-ignore
        this.state={
            sideMenuOn : false,
            currentPod: {
                podName: "Lobo",
                podId: 1,
            }
        }
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
                    this.setState({currentPod: {podName: "JCP", podId: 2}});
                    break;
                case 2 :
                    this.setState({currentPod: {podName: "Athletics", podId: 3}});
                    break;
                case 3 :
                    this.setState({currentPod: {podName: "DSH", podId: 4}});
                    break;
                case 4 :
                    this.setState({currentPod: {podName: "ESCS", podId: 5}});
                    break;
                case 5 :
                    this.setState({currentPod: {podName: "ESCN", podId: 6}});
                    break;
                case 6 :
                    this.setState({currentPod: {podName: "Lobo", podId: 1}});
                    break;
            }
        } else{
            switch (this.state.currentPod.podId) {
                case 1 :
                    this.setState({currentPod: {podName: "ESCN", podId: 6}});
                    break;
                case 2 :
                    this.setState({currentPod: {podName: "Lobo", podId: 1}});
                    break;
                case 3 :
                    this.setState({currentPod: {podName: "JCP", podId: 2}});
                    break;
                case 4 :
                    this.setState({currentPod: {podName: "Athletics", podId: 3}});
                    break;
                case 5 :
                    this.setState({currentPod: {podName: "DSH", podId: 4}});
                    break;
                case 6 :
                    this.setState({currentPod: {podName: "ESCS", podId: 5}});
                    break;
            }
        }
    }

    render(){
        const {sideMenuOn} = this.state;
        const shifts = filterShiftsByPod(this.state.currentPod.podId, this.props.schedule);

        return (
            <div>
                <Navigation scon={this.props.scon} sectionName={"Pod Schedule"} handleMenuClick={this.handleMenuClick.bind(this)}/>
                <SideMenu sideMenuOn={this.state.sideMenuOn}/>
                <div style={{width: '100%', textAlign: 'center'}}>
                    <h1>{this.state.currentPod.podName} Schedule </h1>
                </div>
                <Calendar switcher={this.podSwitcher.bind(this)} switch={true} showScon={true} showPod={false} shifts = {shifts} pods={this.props.pods}/>
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

export default connect(mapStateToProps, null)(PodSchedule);