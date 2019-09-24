import { combineReducers } from 'redux';
import sconReducer from "./SconReducer";
import allSconsReducer from "./AllSconsReducer";
import scheduleReducer from "./ScheduleReducer"
import podReducer from './PodReducer';
const rootReducer = combineReducers({
    scon: sconReducer,
    schedule : scheduleReducer,
    pods: podReducer,
    allScons: allSconsReducer,
});

export default rootReducer;
