import React,{Component} from "react";
import {Grid,Paper,Table,TableBody,TableCell,TableHead,TableRow,Typography} from "@material-ui/core";
import {red,grey} from "@material-ui/core/colors";
//red[900]
//grey[400]
export default class DesktopCalendar extends Component{

    constructor(props){
        super(props);
    }

    styles = {
        calendarContainer : {
            paddingTop: "5vh",
            paddingRight: "5vw",
            paddingLeft : "5vw"
        },
        calendarPaper : {
            width: "90%"
        },
        tableHeader : {
            backgroundColor: red[900],
        },
        tableHeaderCell : {
            color: "#FFFFFF"
        }
    };

    initializeTableHeader(){
        console.log("DoubleShift: " + this.props.doubleshift);

        if(this.props.doubleshift){
            return (
                <TableRow style={this.styles.tableHeader}>
                    <TableCell style={this.styles.tableHeaderCell}>Monday</TableCell>
                    <TableCell style={this.styles.tableHeaderCell}> </TableCell>
                    <TableCell style={this.styles.tableHeaderCell}>Tuesday</TableCell>
                    <TableCell style={this.styles.tableHeaderCell}> </TableCell>
                    <TableCell style={this.styles.tableHeaderCell}>Wednesday</TableCell>
                    <TableCell style={this.styles.tableHeaderCell}> </TableCell>
                    <TableCell style={this.styles.tableHeaderCell}>Thursday</TableCell>
                    <TableCell style={this.styles.tableHeaderCell}> </TableCell>
                    <TableCell style={this.styles.tableHeaderCell}>Friday</TableCell>
                    <TableCell style={this.styles.tableHeaderCell}> </TableCell>
                    <TableCell style={this.styles.tableHeaderCell}>Saturday</TableCell>
                    <TableCell style={this.styles.tableHeaderCell}> </TableCell>
                </TableRow>
            )
        }

        return(
            <TableRow style={this.styles.tableHeader}>
                <TableCell style={this.styles.tableHeaderCell}>Monday</TableCell>
                <TableCell style={this.styles.tableHeaderCell}>Tuesday</TableCell>
                <TableCell style={this.styles.tableHeaderCell}>Wednesday</TableCell>
                <TableCell style={this.styles.tableHeaderCell}>Thursday</TableCell>
                <TableCell style={this.styles.tableHeaderCell}>Friday</TableCell>
                <TableCell style={this.styles.tableHeaderCell}>Saturday</TableCell>
                <TableCell style={this.styles.tableHeaderCell}>Sunday</TableCell>
            </TableRow>
        )
    }


    render() {
        return (
            <Grid container spacing={8} sm={12} justify={"center"} style={this.styles.calendarContainer}>
                <Paper style={this.styles.calendarPaper}>
                    <Table>
                        <TableHead>
                            {this.initializeTableHeader()}
                        </TableHead>
                        <TableBody>
                            <TableRow>
                                <TableCell>Test</TableCell>
                                <TableCell>Test</TableCell>
                                <TableCell>Test</TableCell>
                                <TableCell>Test</TableCell>
                                <TableCell>Test</TableCell>
                                <TableCell>Test</TableCell>
                                <TableCell>Test</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </Paper>
            </Grid>
        )
    }
}