import * as React from "react";
import {bindActionCreators} from "redux";
import {connect} from "react-redux";
import {getAllPods, getScon, getShiftsByShiftPlanName} from "../actions";
import Navigation from "./navigation/Navigation"
import SideMenu from "./navigation/SideMenu";
import Calendar from "./calendar/Calendar";
import {Scon, Shift} from "../interfaces";
import {filterShiftsByScon} from "./calendar/CalendarUtils";

interface State{
    sideMenuOn : boolean
}

interface Props{
    scon : Scon;
    schedule : Array<Shift>;
    pods: Array<any>
    getScon();
    getShiftsByShiftPlanName(shiftPlanName : string);
    getAllPods();
}


class Home extends React.Component<Props,State>{
    constructor(props){
        super(props);
        //@ts-ignore
        this.state={
            sideMenuOn : false
        }
    }

    componentWillMount(){
        this.props.getScon();
        this.props.getShiftsByShiftPlanName("Summer2019");
        this.props.getAllPods();
    }

    handleMenuClick = ()=>{
        this.setState({sideMenuOn : !(this.state.sideMenuOn)});
    };

    render(){
        const {sideMenuOn} = this.state;
        console.log(this.props);
        const shifts = filterShiftsByScon(this.props.scon.netId, this.props.schedule);
        return (
            <div>
                <Navigation scon={this.props.scon} sectionName={"Home"} handleMenuClick={this.handleMenuClick.bind(this)}/>
                <SideMenu sideMenuOn={this.state.sideMenuOn}/>
                <br />
                <div style={{width: '100%', textAlign: 'center'}}>
                    <h1>Your Schedule </h1>
                </div>
                <Calendar showScon={false} showPod={true} shifts = {shifts} pods={this.props.pods}/>
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

export default connect(mapStateToProps,mapDispatchToProps)(Home);