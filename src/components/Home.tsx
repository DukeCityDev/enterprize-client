import * as React from "react";
import {bindActionCreators} from "redux";
import {connect} from "react-redux";
import {getScon,getShiftsByShiftPlanId} from "../actions";
import Navigation from "./navigation/Navigation"
import SideMenu from "./navigation/SideMenu";
import Calendar from "./calendar/Calendar";

export interface Scon {
    adminStatus : boolean,
    email : string,
    firstName : string,
    lastName : string,
    middleInitial : string,
    netId : number,
    sconId : number,
    startDate : Date
}


interface State{
    sideMenuOn : boolean
}

interface Props{
    scon : any,
    getScon(),
    getShiftsByShiftPlanId(id : number)
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
        this.props.getShiftsByShiftPlanId(2);
    }

    handleMenuClick = ()=>{
        console.log("clicked");
        this.setState({sideMenuOn : !(this.state.sideMenuOn)});
        console.log(this.state);
    };

    render(){
        const {sideMenuOn} = this.state;

        return (
            <div>
                <Navigation scon={this.props.scon} sectionName={"Home"} handleMenuClick={this.handleMenuClick.bind(this)}/>
                <SideMenu sideMenuOn={this.state.sideMenuOn}/>
                <Calendar/>
            </div>
        )
    }
}

function mapStateToProps(state){
    return {
        scon: state.scon,
        schedule : state.schedule
    }
}

const mapDispatchToProps = (dispatch)=>{
    return bindActionCreators({getScon,getShiftsByShiftPlanId},dispatch);
};

export default connect(mapStateToProps,mapDispatchToProps)(Home);