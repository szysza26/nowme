import React, {useEffect, useState} from 'react';
import {makeStyles} from "@material-ui/core/styles";
import {Paper, Box, Typography} from "@material-ui/core";
import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet'
import 'leaflet/dist/leaflet.css';

import L from 'leaflet';
import icon from 'leaflet/dist/images/marker-icon.png';
import axios from "axios";
let DefaultIcon = L.icon({
    iconUrl: icon
});
L.Marker.prototype.options.icon = DefaultIcon;

const useStyles = makeStyles({
    paper: {
        padding: '8px',
        marginBottom: '10px',
    },
    root: {
        height: "400px",
        width: "100%",
    }
});

const MapResult = (props) => {
    const classes = useStyles();

    const [result, setResult] = useState([]);

    useEffect(() => {
        if(props.result) {
            props.result.forEach((element, index) => {
                axios.get("https://nominatim.openstreetmap.org/search.php?format=json&q=" + element.office)
                    .then((res) => {
                        let office = {
                            key: index,
                            name: element.specialist + " " + element.office,
                            lng: res.data[0].lon,
                            lat: res.data[0].lat
                        }
                        result.push(office);
                        //setResult([...result, office]);
                    })
                    .catch((error) => {
                        console.log(error)
                    });
            })
        }

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [props.result])

    const renderMarkers = () => {
        return result.map(element =>
                <Marker
                    key={element.name}
                    position={[element.lat, element.lng]}
                >
                    <Popup>
                        {element.name}
                    </Popup>
                </Marker>
            )
    }

    return (
        <>
            <Paper className={classes.paper}>
                <MapContainer center={[53.43, 14.57]} zoom={12} scrollWheelZoom={false} className={classes.root}>
                    <TileLayer
                        attribution='&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    />
                    {result.length > 0 && renderMarkers()}
                </MapContainer>
            </Paper>
        </>
    );
}

export default MapResult;