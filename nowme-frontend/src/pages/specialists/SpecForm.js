import React, { useState } from 'react';
import { makeStyles } from '@material-ui/core/styles';
import { Grid, TextField, MenuItem, Button } from '@material-ui/core';

const useStyles = makeStyles({
    button: {
        padding: '16px',
    }
});

const specs = ['Fryzjer', 'Barber', 'Lekarz', 'Kosmetolog'];

const SpecForm = (props) => {
    const classes = useStyles();

    const [firstName, setFirstName] = useState(props.data.firstName ? props.data.firstName : '');
    const [lastName, setLastName] = useState(props.data.lastName ? props.data.lastName : '');
    const [spec, setSpec] = useState(props.data.spec ? props.data.spec : '');
    const [telephone, setTelephone] = useState(props.data.telephone ? props.data.telephone : '');
    const [address, setAddress] = useState(props.data.address ? props.data.address : '');
    const [city, setCity] = useState(props.data.city ? props.data.city : '');
    const [zip, setZip] = useState(props.data.zip ? props.data.zip : '');

    const handleChange = (event) => {
        switch(event.target.name){
            case 'firstName':
                setFirstName(event.target.value);
                break;
            case 'lastName':
                setLastName(event.target.value);
                break;
            case 'spec':
                setSpec(event.target.value);
                break;
            case 'telephone':
                setTelephone(event.target.value);
                break;
            case 'address':
                setAddress(event.target.value);
                break;
            case 'city':
                setCity(event.target.value);
                break;
            case 'zip':
                setZip(event.target.value);
                break;
            default:
                console.log('can not handle this value');
        }
    }

    const handleClick = (event) => {
        if(props.isEdit){
            console.log('edit')
        }else{
            console.log('add')
        }

        setFirstName('');
        setLastName('');
        setSpec('');
        setTelephone('');
        setAddress('');
        setCity('');
        setZip('');
    }

    return (
        <Grid container spacing={3}>
            <Grid item xs={12} md={6}>
                <TextField
                    required
                    name="firstName"
                    label="First name"
                    fullWidth
                    value={firstName}
                    onChange={handleChange}
                    InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                />
            </Grid>
            <Grid item xs={12} md={6}>
                <TextField
                    required
                    name="lastName"
                    label="Last name"
                    fullWidth
                    value={lastName}
                    onChange={handleChange}
                    InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                />
            </Grid>
            <Grid item xs={12} md={6}>
                <TextField
                    required
                    name="spec"
                    label="Spec"
                    select
                    fullWidth
                    value={spec}
                    onChange={handleChange}
                    InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                    >
                    {specs.map((option) => (
                        <MenuItem key={option} value={option}>
                            {option}
                        </MenuItem>
                    ))}
                </TextField>
            </Grid>
            <Grid item xs={12} md={6}>
                <TextField
                    required
                    name="telephone"
                    label="telephone number"
                    fullWidth
                    value={telephone}
                    onChange={handleChange}
                    InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                />
            </Grid>
            <Grid item xs={12}>
                <TextField
                    required
                    name="address"
                    label="Address"
                    fullWidth
                    value={address}
                    onChange={handleChange}
                    InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                />
            </Grid>
            <Grid item xs={12} md={6}>
                <TextField
                    required
                    name="city"
                    label="City"
                    fullWidth
                    value={city}
                    onChange={handleChange}
                    InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                />
            </Grid>
            <Grid item xs={12} md={6}>
                <TextField
                    required
                    name="zip"
                    label="Zip / Postal code"
                    fullWidth
                    value={zip}
                    onChange={handleChange}
                    InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                />
            </Grid>
            {props.action !== "show" &&
            <Grid item xs={4} sm={3} md={2} className={classes.button}>
                <Button variant="contained" color="primary" onClick={handleClick} fullWidth>
                    {props.action === 'add' ? "ADD" : "EDIT"}
                </Button>
            </Grid>
            } 
        </Grid>
    )
}

export default SpecForm
