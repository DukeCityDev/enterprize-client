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

        const width = this.props.sideMenuOn ? "33.33%" : "0%";
        return (
            <div id={"side-menu"} style={{width}} >

            </div>
        )
    }
}