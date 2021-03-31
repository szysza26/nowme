import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import { Box, Container, Card, CardContent, Typography } from '@material-ui/core'

const useStyles = makeStyles({
    root: {
      minWidth: 275,
      marginTop: "10px",
      textAlign: 'center',
    },
  });

const Home = (props) => {
    const classes = useStyles();

    return(
        <Container flex>
            <Card className={classes.root} variant="outlined">
                <CardContent>
                    <Typography variant="h5" component="h2">
                        Home !!!
                    </Typography>
                </CardContent>
            </Card>
        </Container>
    )
}

export default Home;