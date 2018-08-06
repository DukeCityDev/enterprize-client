import React,{Component} from "react";
import {AppBar} from "@material-ui/core";
import {Toolbar} from "@material-ui/core";
import {Typography} from "@material-ui/core";
import {Button} from "@material-ui/core";

export default class NavigationBar extends Component{



    constructor(props){
        super(props);
    }


    render(){
        return (
            <AppBar position="static" color={"#2196f3"}>
                <Toolbar  color={"#2196f3"}>
                    {/*<IconButton color="inherit" aria-label="Menu">*/}
                    {/*</IconButton>*/}
                    <Typography variant="title" color="inherit">
                        News
                    </Typography>
                    <Button color="inherit">Login</Button>
                </Toolbar>
            </AppBar>        );
    }

}