import React, {useState} from 'react';
import { TableCell, TableRow, Button, ButtonGroup } from '@material-ui/core';

import SpecForm from './SpecForm';

const SpecRow = (props) => {

    const [action, setAction] = useState('');

    const handleClickShow = () => {
        action === 'show' ? setAction('') : setAction('show');
    }
    const handleClickEdit = () => {
        action === 'edit' ? setAction('') : setAction('edit');
    }
    const handleClickDelete = () => {
        console.log("delete");
    }

    return(
    <>
        <TableRow selected={action ? true : false}>
            <TableCell align="center" component="th" scope="row">{props.data.id}</TableCell>
            <TableCell align="center">{props.data.firstName}</TableCell>
            <TableCell align="center">{props.data.lastName}</TableCell>
            <TableCell align="center">{props.data.spec}</TableCell>
            <TableCell align="center">
                <ButtonGroup variant="contained" aria-label="contained button group">
                    <Button onClick={handleClickShow} size="small" color="primary">Show</Button>
                    <Button onClick={handleClickEdit} size="small">Edit</Button>
                    <Button onClick={handleClickDelete} size="small" color="secondary">Delete</Button>
                </ButtonGroup>
            </TableCell>
        </TableRow>
        {action === 'show' &&
            <TableRow selected>
                <TableCell colSpan={5}>
                    <SpecForm action={"show"} data={props.data}/>
                </TableCell>
            </TableRow>
        }
        {action === 'edit' &&
            <TableRow selected>
                <TableCell colSpan={5}>
                    <SpecForm action={"edit"} data={props.data}/>
                </TableCell>
            </TableRow>
        }
    </>
    )
}

export default SpecRow;