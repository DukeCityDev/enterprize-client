import { combineReducers } from 'redux';
import sconReducer from "./SconReducer";
import scheduleReducer from "./ScheduleReducer"

const rootReducer = combineReducers({
    scon: sconReducer,
    schedule : scheduleReducer
});

export default rootReducer;
