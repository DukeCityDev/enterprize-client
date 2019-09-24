import {GET_PODS} from "../actions";

export default function (state=[],action){
    switch(action.type){
        case GET_PODS:
            return action.payload;
        default:
            return state;
    }
}