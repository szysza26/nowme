import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import { Container, Card, CardContent, Typography, Button } from '@material-ui/core'
import jwt_decode from 'jwt-decode';

const useStyles = makeStyles({
    root: {
      minWidth: 275,
      marginTop: "10px",
      textAlign: 'center',
    },
  });

const Profile = (props) => {
    const classes = useStyles();

    const handleClickLogout = () => {
        props.setToken('');
    }

    return(
        <Container component="main" maxWidth="md">
            <Card className={classes.root} variant="outlined">
                <CardContent>
                    <Typography variant="h3">
                        Profile !!!
                        <Button variant="contained" color="primary" onClick={handleClickLogout}>
                            Logout
                        </Button>
                    </Typography>
                </CardContent>
            </Card>
        </Container>
    )
}

export default Profile;