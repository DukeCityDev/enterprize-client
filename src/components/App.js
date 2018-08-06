import React,{Component} from "react";
import Typography from '@material-ui/core/Typography';
import NavigationBar from "./NavigationBar";

export default class App extends Component{
    render(){
        return (
            <div>
                <NavigationBar/>
                <Typography variant="display4" gutterBottom>
                    Display 4
                </Typography>
            </div>

    )
    };
}