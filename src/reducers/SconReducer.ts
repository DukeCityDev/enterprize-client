import {GET_SCON} from '../actions'


export default function (state={},action){
    switch(action.type){
        case GET_SCON:
            return action.payload.data;
        default:
            return state;
    }
}