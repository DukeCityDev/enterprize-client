import * as React from "react";
import {Scon} from "../../interfaces";

interface Props{
    modelAction(open: boolean),
    scon: Scon,
}

interface State{
    new: boolean;
    formResult: boolean;
    adminStatus : boolean;
    email : string;
    firstName : string;
    lastName : string;
    netId : string;
    phoneNumber: string|number;
}

export default class SconModal extends React.Component<Props,State>{

    constructor(props){
        super(props);
        this.state = {
            new: !this.props.scon.netId,
            formResult: false,
            adminStatus: this.props.scon.adminStatus,
            email: this.props.scon.email,
            firstName: this.props.scon.firstName,
            lastName: this.props.scon.lastName,
            netId: this.props.scon.netId,
            phoneNumber: this.props.scon.phoneNumber,
        };
    }

    formSubmit = (event) => {
        this.setState({formResult: true});
        setTimeout(() => {
            this.setState({formResult: false});
        }, 2000);
    };

    returnFormResultWait = () => {
        return (
            <div id={"form-result"}>
                <h2>Submitting {this.props.scon.netId ? "New Scon":"Edit Scon"} Request</h2>
            </div>
        )
    };

    changeAdminStatus = () => {
        this.setState({adminStatus: !this.state.adminStatus});
    };

    changeFormStringValue = (event) =>{
        //@ts-ignore
        this.setState({[event.target.name] : event.target.value});
    };

    render(){
        return(
            <div id={"modal"}>
                <div id={"modal-main"}>
                    <div className={"modal-header"}>
                        <button onClick={(event) => this.props.modelAction(false)}><h4>Close</h4></button>
                    </div>
                    <div className={"modal-title"}>
                        <h1>{this.props.scon.netId ? 'Edit' : 'Create'} Scon:</h1>
                    </div>
                    {!this.state.formResult ? <form className={"scon-modal-form"}>
                        <label htmlFor={"netId"}>Net Id</label>
                        <input className={'scon'} name={'netId'} type={'text'} value={this.state.netId} onChange={(event) => {this.changeFormStringValue(event)}} />
                        <label htmlFor={"adminStatus"}>Admin Status</label>
                        <input className={'scon'} checked={this.state.adminStatus} name={'adminStatus'} type={'checkbox'} onChange={(event) => {this.changeAdminStatus()}}/>
                        <label htmlFor={"firstName"}>First Name</label>
                        <input className={'scon'} name={'firstName'} type={'text'} value={this.state.firstName} onChange={(event) => {this.changeFormStringValue(event)}}/>
                        <label htmlFor={"lastName"}>Last Name</label>
                        <input className={'scon'} name={'lastName'}  type={'text'} value={this.state.lastName} onChange={(event) => {this.changeFormStringValue(event)}}/>
                        <label htmlFor={"email"}>Email</label>
                        <input className={'scon'} name={'email'} type={'text'} value={this.state.email} onChange={(event) => {this.changeFormStringValue(event)}}/>
                        <label htmlFor={"phoneNumber"}>Phone Number</label>
                        <input className={'scon'} name={"phoneNumber"} type={'text'} value={this.state.phoneNumber} onChange={(event) => {this.changeFormStringValue(event)}}/>
                    </form> : this.returnFormResultWait()}
                    <div className={"modal-footer"}>
                        <button id={"submit-scon"} onClick={(event)=>{this.formSubmit(event)}}><h3>Submit</h3></button>
                    </div>
                </div>
            </div>
        )

    }
}