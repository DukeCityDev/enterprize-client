import {GET_SHIFTS} from "../actions";

export default function (state=[],action){
    switch(action.type){
        case GET_SHIFTS:
            return action.payload;
        default:
            return state;
    }
}