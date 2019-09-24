import * as React from "react";
import {Shift} from "../../interfaces";
import {formatDate, formatTime, parsePod} from "./CalendarUtils";

interface Props{
    modelAction(open: boolean),
    shift: Shift,
    pods: Array<any>
}

interface State{
    formOn: boolean;
    coverage: boolean;
    reason: string;
    approvingScon: string;
    formResult: boolean;
}
export default class CalendarModal extends React.Component<Props,State>{

    constructor(props){
        super(props);
        this.state = {
            formOn: false,
            coverage: true,
            reason: "",
            approvingScon: "",
            formResult: false,
        };
    }

    formSubmit = (event) => {
        this.setState({formResult: true});
        setTimeout(() => {
            this.setState({formResult: false});
        }, 2000);
    };

    formButtonClick = (buttonType, event) => {
        event.preventDefault();
        if(buttonType == 'close'){
            this.setState({formOn: false});
        }else{
            this.formSubmit(event);
        }
    };

    footerButtonClick = (buttonType) => {
        if(buttonType == 'Giveaway'){
            this.setState({coverage: false, formOn: true});
        } else{
            this.setState({coverage: true, formOn: true})
        }
    };

    formChange = (formField, event) => {
        if(formField == 'reason'){
            this.setState({reason: event.target.value});
        } else{
            this.setState({approvingScon: event.target.value})
        }
    };

    returnFormResultWait = () => {
       return (
           <div id={"form-result"}>
               <h2>Submitting {this.state.coverage ? "Coverage":"Giveaway"} Request</h2>
           </div>
       )
    };

    render(){
        console.log(this.props.shift);
        return(
            <div id={"modal"}>
                <div id={"modal-main"}>
                    <div className={"modal-header"}>
                        <button onClick={(event) => this.props.modelAction(false)}><h4>Close</h4></button>
                    </div>
                    <div className={"modal-title"}>
                        <h1>Shift Info:</h1>
                    </div>
                    <div className={"modal-content"}>
                        <h3>
                            <p>{this.props.shift.sconNetId}</p>
                            <p>{parsePod(this.props.shift.podId, this.props.pods)}</p>
                            <p>{formatDate(this.props.shift.startDate.date)}</p>
                            <p>{formatTime(this.props.shift.startDate.date)} to {formatTime(this.props.shift.endDate.date)}</p>
                        </h3>
                    </div>
                    {this.state.formResult? this.returnFormResultWait() :<form id={"coverage-form"} className={this.state.formOn ? "open": "closed"}>
                        <h2>{this.state.coverage ? "Coverage":"Giveaway"}</h2>
                        <label>Reason</label>
                        <input type={"text"} onChange={(event)=>{this.formChange("reason", event)}} value={this.state.reason} />
                        <label>Approving Scon: </label>
                        <input onChange={(event)=>{this.formChange("approvingScon", event)}} type={"text"} value={this.state.approvingScon} />
                        <div className={"submitContainer"}>
                            <button className={"close"} onClick={(event)=>{this.formButtonClick("close", event)}}>Close</button>
                            <button onClick={(event)=>{this.formButtonClick("submit", event)}}>Submit</button>
                        </div>
                    </form>}
                    <div className={"modal-footer"}>
                        <button id={"giveaway"} onClick={(event)=>{this.footerButtonClick("Giveaway")}}><h3>Giveaway</h3></button>
                        <button id={"coverage"} onClick={(event)=>{this.footerButtonClick("Coverage")}}><h3>Coverage</h3></button>
                    </div>
                </div>
            </div>
        )

    }
}

