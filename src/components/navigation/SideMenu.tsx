import * as React from "react";
import {Link} from "react-router-dom";

interface Props{
    sideMenuOn : boolean
}

interface State{

}

export default class SideMenu extends React.Component<Props,State>{
    constructor(props){
        super(props);
    }

    render(){

        const width = this.props.sideMenuOn ? "33.33%" : "0%";
        return (
            <div id={"side-menu"} style={{width}} >
                <div className={"side-menu-item"}>
                    <Link to={'/sconsdocdev'}><h3>Your Schedule</h3></Link>
                </div>
                <div className={"side-menu-item"}>
                    <Link to={'/pods'}><h3>Pod Schedule</h3></Link>
                </div>
                <div className={"side-menu-item"}>
                    <Link to={'/weekday'}><h3>Weekday Schedule</h3></Link>
                </div>
                <div className={"side-menu-item"}>
                    <Link to={'/scons'}><h3>Scons</h3></Link>
                </div>
                <div className={"side-menu-item"}>
                    <Link to={'/pods'}><h3>Analytics</h3></Link>
                </div>
                <div className={"side-menu-item"}>
                    <Link to={'/pods'}><h3>Coverages</h3></Link>
                </div>
                <div className={"side-menu-item"}>
                    <Link to={'/pods'}><h3>Giveaways</h3></Link>
                </div>
                <div className={"side-menu-item"}>
                    <Link to={'/make-schedule'}><h3>Make Schedule</h3></Link>
                </div>
                <div className={"side-menu-item"}>
                    <Link to={'/pods'}><h3>Switch Schedule</h3></Link>
                </div>
            </div>
        )
    }
}