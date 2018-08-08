import React,{Component} from "react";
import Typography from '@material-ui/core/Typography';
import NavigationBar from "./NavigationBar";
import {theme} from "./UNMTheme";
import {MuiThemeProvider} from "@material-ui/core"
import {getScon} from "../actions";
import {connect} from "react-redux";
import {bindActionCreators} from "redux";


class App extends Component{

    constructor(props){
        super(props);

        this.props.getScon()
            .then(result=>{
               console.log("Result: " + JSON.stringify(result.payload.data.data));
            });
    }


    render(){
        console.log(this.props.scon);
        const {firstName,lastName} =this.props.scon;
        return (
            <div>
                <MuiThemeProvider theme={theme}>
                    <NavigationBar color={'primary'}/>
                    <Typography variant="display4" gutterBottom>
                        Greetings {firstName} {lastName}
                    </Typography>
                </MuiThemeProvider>
            </div>

        )
    };
}

function mapStateToProps(state){
    return {
        scon: state.scon
    }
}

const mapDispatchToProps = (dispatch)=>{

    return bindActionCreators({getScon},dispatch);
};

export default connect(mapStateToProps,mapDispatchToProps)(App);