import React, {useState} from 'react';
import { makeStyles } from '@material-ui/core/styles';
import { Container, Card, CardContent, Typography } from '@material-ui/core'
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

    const [jwt] = useState(jwt_decode(props.token));

    return(
        <Container component="main" maxWidth="md">
            <Card className={classes.root} variant="outlined">
                <CardContent>
                    <Typography variant="h3">
                        {"Witaj " + jwt.username}
                    </Typography>
                    <Typography variant="h5">
                        {"Role: " + jwt.roles}
                    </Typography>
                    <Typography variant="h5">
                        {"Token ważny do: " + new Date(jwt.exp * 1000).toLocaleString()}
                    </Typography>
                </CardContent>
            </Card>
        </Container>
    )
}

export default Profile;