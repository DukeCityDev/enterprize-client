import {GET_ALL_SCONS} from "../actions";

export default function (state=[],action){
    switch(action.type){
        case GET_ALL_SCONS:
            return action.payload;
        default:
            console.log('DEFAULT PAYLOAD RETURNED!!!');
            return state;
    }
}