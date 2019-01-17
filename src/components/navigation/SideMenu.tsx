import * as React from "react";

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
        return (<b>Test: {this.props.sideMenuOn}</b>)
    }
}