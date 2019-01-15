import * as React from "react";
import {bindActionCreators} from "redux";
import {connect} from "react-redux";
import {getScon} from "../actions";

interface Scon {

}

interface State{

}

interface Props{
    scon : any,
    getScon()
}


class Home extends React.Component<Props,State>{
    constructor(props){
        super(props);
    }

    componentWillMount(){
        this.props.getScon();
    }

    render(){
        console.log("PROPS");
        console.log(this.props.scon);
        return (
            <div>
                Hello World!

                {(this.props.scon.netId ? this.props.scon.netId : 'Undefined')}
            </div>
        )
    }
}




function mapStateToProps(state){
    return {
        scon: state.scon
    }
}

const mapDispatchToProps = (dispatch)=>{

    return bindActionCreators({getScon},dispatch);
};

export default connect(mapStateToProps,mapDispatchToProps)(Home);