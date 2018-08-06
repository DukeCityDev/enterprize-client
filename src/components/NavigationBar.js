import React,{Component} from "react";
import {AppBar} from "@material-ui/core";
import {Toolbar} from "@material-ui/core";
import {Typography} from "@material-ui/core";
import {Button} from "@material-ui/core";
import {Menu} from "@material-ui/core";
import {IconButton} from "@material-ui/core";
import AccountCircle from '@material-ui/icons/AccountCircle';


export default class NavigationBar extends Component{


    constructor(props){
        super(props);
    }


    render(){
        return (
            <AppBar position="static" color={"primary"}>
                <Toolbar>
                    <Button color="inherit">Menu 1</Button>
                    <Button color="inherit">Menu 2</Button>
                    <Button color="inherit">Menu 3</Button>
                    <Button color="inherit">Menu 4</Button>
                    <Button color="inherit">Menu 5</Button>
                </Toolbar>
            </AppBar>);
    }

}