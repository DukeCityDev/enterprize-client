import {createMuiTheme} from '@material-ui/core';
import {red,grey} from "@material-ui/core/colors";

export const theme = createMuiTheme({
    palette: {
        primary: {main: red[900]},
        secondary: {main: grey[400]}
    }
});
