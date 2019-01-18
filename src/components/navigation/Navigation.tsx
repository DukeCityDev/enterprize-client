import * as React from "react";
import {Scon} from "../Home";

interface Props{
    handleMenuClick(),
    scon : Scon,
    sectionName : string
}

interface State{

}

export default class Navigation extends React.Component<Props,State>{
    constructor(props){
     super(props);

    }



    render(){
        return (
        <nav className={"red-background"} id={'navigation-bar'}>
            <div onClick={this.props.handleMenuClick} className={"nav-item"} style={{float : "left"}}><a>Menu</a></div>
            <div className={"nav-item"} id={"center-nav-item"}><a>{this.props.sectionName}</a></div>
            <div className={"nav-item"} style={{float : "left"}}><a>{this.props.scon.firstName} {this.props.scon.lastName}</a></div>
        </nav>
        );
    }
}