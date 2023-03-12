import React, { Component } from 'react';
import './App.css';

class App extends Component {
  constructor(props) {
    super(props);
    this.state = { clicks: 0 };
  }

  clickHandler(evt) {
    evt.preventDefault();
    const { clicks } = this.state;
    let increasedClicks = clicks + 1;
    this.setState( { clicks: increasedClicks } );
  }

  render() {
    const { clicks } = this.state;

    return (
      <div className="App">
        {clicks === 0 &&
        <p>Es wurde noch nicht geklickt.</p>}
        {clicks === 1 &&
        <p>Bisher 1 Klick.</p>}
        {clicks > 1 &&
        <p>Bisher {clicks} Klicks.</p>}
        <p><button onClick = {evt => this.clickHandler(evt)}>Noch ein Klick</button></p>
      </div>
    );
  }

}

export default App;

