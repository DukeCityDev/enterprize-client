import * as React from "react";
import axios from "axios";

interface Props{

}

interface State{

}

export default class Calendar extends React.Component<Props,State>{
    constructor(props){
        super(props);
    }

    render(){
        return(
            <div id={"calendar-container"}>
                <table id={"calendar-full-size"}>
                    <th>
                        Ayyyyy
                    </th>
                </table>
            </div>
        )
    }
}