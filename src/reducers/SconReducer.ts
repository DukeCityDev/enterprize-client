import {GET_SCON} from '../actions'


export default function (state={},action){
    console.log(action.type);
    console.log(action.payload);
    switch(action.type){
        case GET_SCON:
            return action.payload.data;
        default:
            return state;
    }
}