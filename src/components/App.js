import React,{Component} from "react";
import Typography from '@material-ui/core/Typography';
import NavigationBar from "./NavigationBar";
import {theme} from "./UNMTheme";
import {MuiThemeProvider} from "@material-ui/core"


export default class App extends Component{
    render(){
        return (
            <div>
                <MuiThemeProvider theme={theme}>
                    <NavigationBar color={'primary'}/>
                    <Typography variant="display4" gutterBottom>
                        Display 4
                    </Typography>
                </MuiThemeProvider>
            </div>

    )
    };
}