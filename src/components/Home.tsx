import * as React from "react";
import {bindActionCreators} from "redux";
import {connect} from "react-redux";
import {getScon,getShiftsByShiftPlanId} from "../actions";
import Navigation from "./navigation/Navigation"
import SideMenu from "./navigation/SideMenu";
import Calendar from "./calendar/Calendar";
import {Scon, Shift} from "../interfaces";

interface State{
    sideMenuOn : boolean
}

interface Props{
    scon : Scon,
    schedule : Array<Shift>,
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
        this.setState({sideMenuOn : !(this.state.sideMenuOn)});
    };

    render(){
        console.log(this.props);
        const {sideMenuOn} = this.state;

        return (
            <div>
                <Navigation scon={this.props.scon} sectionName={"Home"} handleMenuClick={this.handleMenuClick.bind(this)}/>
                <SideMenu sideMenuOn={this.state.sideMenuOn}/>
                <Calendar shifts = {this.props.schedule}/>
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