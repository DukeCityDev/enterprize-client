import * as React from "react";
import {bindActionCreators} from "redux";
import {connect} from "react-redux";
import {getAllPods, getAllScons, getScon, getShiftsByShiftPlanName} from "../../actions";
import Navigation from "../navigation/Navigation"
import SideMenu from "../navigation/SideMenu";
import {Scon, Shift} from "../../interfaces";
import {SconRow} from "./SconRow";
import SconModal from "./SconModal";
import {filterShiftsByScon} from "../calendar/CalendarUtils";

interface State{
    sideMenuOn : boolean,
    modalOpen: boolean,
    focusScon: Scon,
    sconSearch: string,
}

interface Props{
    scon : Scon;
    schedule : Array<Shift>;
    pods: Array<any>,
    allScons: Array<Scon>
    getScon();
    getAllScons();
    getAllPods();
    getShiftsByShiftPlanName(shiftPlan: string);
}

class Scons extends React.Component<Props,State>{

    constructor(props){
        super(props);
        //@ts-ignore
        this.state={
            sideMenuOn : false,
            modalOpen : false,
            focusScon: null,
            sconSearch: '',
        }
    }

    componentWillMount(){
        this.props.getScon();
        this.props.getAllScons();
        if(this.props.pods.length == 0){
            this.props.getAllPods();
        }
        if(this.props.schedule.length == 0){
            this.props.getShiftsByShiftPlanName("Summer2019");
        }
    }

    changeSearch(event){
        this.setState({sconSearch: event.target.value.trim()});
    }

    sconModal = (open: boolean, scon?: Scon) => {
        if(open){
            this.setState({modalOpen: true, focusScon: scon});
        } else{
            this.setState({modalOpen: false});
        }
    };

    handleMenuClick = ()=>{
        this.setState({sideMenuOn : !(this.state.sideMenuOn)});
    };

    filterScon = (searchTerm: string, sconList: Array<Scon>)=>{
        searchTerm = searchTerm.toLowerCase();
        const filteredSconList = sconList.filter((scon) => {
            return (scon.netId.toLowerCase().includes(searchTerm) || scon.firstName.toLowerCase().includes(searchTerm) || scon.lastName.toLowerCase().includes(searchTerm));
        });

        return filteredSconList;
    };

    render(){
        const {sideMenuOn, sconSearch} = this.state;
        const filteredSconList = this.filterScon(sconSearch, this.props.allScons);
        return (
            <div>
                <Navigation scon={this.props.scon} sectionName={"Home"} handleMenuClick={this.handleMenuClick.bind(this)}/>
                <SideMenu sideMenuOn={this.state.sideMenuOn}/>
                <br />
                <div style={{width: '100%', textAlign: 'center'}}>
                    <h1>Scon List </h1>
                    <button id={"create-scon"} onClick={(event => {this.sconModal(true, {
                        netId: undefined,
                        firstName: "",
                        lastName: '',
                        sconId: null,
                        adminStatus: false,
                        startDate: new Date(),
                        middleInitial: '',
                        email: '',
                        phoneNumber: '',
                    } )})}>Create New Scon</button>
                </div>
                <br />
                <div id={"scon-search-container"}>
                    <label htmlFor={"scon-search"}>Search</label>
                    <input name={"scon-search"} type={"text"} onChange={(event) => {this.changeSearch(event)}}/>
                </div>
                <br />
                {this.state.modalOpen ? <SconModal scon={this.state.focusScon} modelAction={this.sconModal.bind(this)} /> : null}
                <table className={"scon-table"}>
                    <thead>
                        <tr className={"header"}>
                            <th>Net Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Admin</th>
                            <th>Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        {filteredSconList.map(scon => <SconRow handleRowClick={this.sconModal.bind(this)} scon={scon} shifts={filterShiftsByScon(scon.netId, this.props.schedule)}/>)}
                    </tbody>
                </table>

            </div>
        )
    }
}

function mapStateToProps(state){
    return {
        scon: state.scon,
        allScons: state.allScons,
        pods: state.pods,
        schedule : state.schedule,
    }
}

const mapDispatchToProps = (dispatch)=>{
    return bindActionCreators({getScon, getAllScons,getShiftsByShiftPlanName,getAllPods},dispatch);
};

export default connect(mapStateToProps,mapDispatchToProps)(Scons);