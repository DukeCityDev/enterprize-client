import GET_SCON from '../actions'


export default function (state={},action){

    switch(action.type){
        case GET_SCON:
            console.log(action.payload.data);
            return {...state, scon: action.payload.data};
        default:
            return state;
    }
}