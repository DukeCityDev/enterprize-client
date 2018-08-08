import { combineReducers } from 'redux';
import {sconReducer} from "./SconReducer";

const rootReducer = combineReducers({
    scon: sconReducer
});

export default rootReducer;
