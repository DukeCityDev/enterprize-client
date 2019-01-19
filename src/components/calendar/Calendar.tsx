import * as React from "react";
import {Shift} from "../../interfaces";

interface Props{
    shifts : Array<Shift>
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