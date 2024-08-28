import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, Button, TextInput } from 'react-native';
import DateTimePicker from '@react-native-community/datetimepicker';
import { Picker } from '@react-native-picker/picker';
import axios from 'axios';

const HomeScreen = ({ route, navigation }) => {
  const [date, setDate] = useState(new Date());
  const [showDatePicker, setShowDatePicker] = useState(false);
  const [selectedTime, setSelectedTime] = useState('');
  const [selectedSalon, setSelectedSalon] = useState('');
  const [selectedFrizer, setSelectedFrizer] = useState('');
  const [selectedTreatment, setSelectedTreatment] = useState('');
  const [frizers, setFrizers] = useState([]);
  const [treatments, setTreatments] = useState([]);
  const [availableTimes, setAvailableTimes] = useState([
    '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
    '12:00', '12:30', '13:00', '13:30', '14:00', '14:30'
  ]);
  const [comment, setComment] = useState('');
  const { userId } = route.params;

  useEffect(() => {
    console.log('Selected Salon:', selectedSalon);
    if (selectedSalon) {
      // Fetch frizers
      axios.get(`http://kv.stud.vts.su.ac.rs/fetch_frizer.php?salon_id=${selectedSalon}&type=frizers`)
        .then(response => setFrizers(response.data))
        .catch(error => console.error('Error fetching frizers:', error));

      // Fetch treatments
      axios.get(`http://kv.stud.vts.su.ac.rs/fetch_treatment.php?salon_id=${selectedSalon}&type=treatments`)
        .then(response => setTreatments(response.data))
        .catch(error => console.error('Error fetching treatments:', error));
    }
  }, [selectedSalon]);


  const handleReservation = () => {
    const startTime = `${date.toISOString().split('T')[0]} ${selectedTime}:00`;

    const startDate = new Date(startTime);

    const endDate = new Date(startDate.getTime() + 30 * 60000);

    const formattedEndTime = `${endDate.toISOString().split('T')[0]} ${endDate.toTimeString().split(' ')[0].slice(0, 5)}`;

    const reservationData = {
      store_id: selectedSalon,
      date: date.toISOString().split('T')[0],
      start_time: startTime,
      end_time: formattedEndTime,
      user_id: userId,
      frizer_id: selectedFrizer,
      treatment_id: selectedTreatment,
      comment: comment
    };

    axios.post('http://kv.stud.vts.su.ac.rs/reservation.php', reservationData)
      .then(response => {
        alert('Reservation successful!');
      })
      .catch(error => {
        console.error('Error creating reservation:', error);
        alert('Failed to create reservation.');
      });
  };

  const handleShowActiveReservations = () => {
    navigation.navigate('ActiveReservations', { userId: userId });
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Select Appointment Details</Text>

      <View style={styles.pickerContainer}>
        <Button onPress={() => setShowDatePicker(true)} title="Select Date" />
        {showDatePicker && (
          <DateTimePicker
            value={date}
            mode="date"
            display="default"
            onChange={(event, selectedDate) => {
              const currentDate = selectedDate || date;
              setShowDatePicker(false);
              setDate(currentDate);
            }}
          />
        )}
        <Text>Selected Date: {date.toDateString()}</Text>
      </View>

      <View style={styles.pickerContainer}>
        <Text>Select Time</Text>
        <Picker
          selectedValue={selectedTime}
          onValueChange={(itemValue) => setSelectedTime(itemValue)}
        >
          {availableTimes.map(time => (
            <Picker.Item key={time} label={time} value={time} />
          ))}
        </Picker>
      </View>

      <View style={styles.pickerContainer}>
        <Text>Select Salon</Text>
        <Picker
          selectedValue={selectedSalon}
          onValueChange={(itemValue) => setSelectedSalon(itemValue)}
        >
          <Picker.Item label="Select a Salon" value="" />
          <Picker.Item label="Hairway to Heaven" value="1" />
          <Picker.Item label="Trim Trends" value="2" />
          <Picker.Item label="Hair Hub" value="3" />
          <Picker.Item label="Timeless Trims" value="4" />
          <Picker.Item label="Vajers Place" value="5" />
          <Picker.Item label="Bark and Bath Boutique" value="6" />
        </Picker>
      </View>

      <View style={styles.pickerContainer}>
        <Text>Select Frizer</Text>
        <Picker
          selectedValue={selectedFrizer}
          onValueChange={(itemValue) => setSelectedFrizer(itemValue)}
          enabled={frizers.length > 0}
        >
          <Picker.Item label="Select a Frizer" value="" />
          {frizers.map(frizer => (
            <Picker.Item key={frizer.frizer_id} label={frizer.frizer_name} value={frizer.frizer_id} />
          ))}
        </Picker>
      </View>

      <View style={styles.pickerContainer}>
        <Text>Select Treatment</Text>
        <Picker
          selectedValue={selectedTreatment}
          onValueChange={(itemValue) => setSelectedTreatment(itemValue)}
          enabled={treatments.length > 0}
        >
          <Picker.Item label="Select a Treatment" value="" />
          {treatments.map(treatment => (
            <Picker.Item key={treatment.treatment_id} label={treatment.treatment_name} value={treatment.treatment_id} />
          ))}
        </Picker>
      </View>

      <View style={styles.textAreaContainer}>
        <Text>Comment</Text>
        <TextInput
          style={styles.textArea}
          multiline
          numberOfLines={4}
          value={comment}
          onChangeText={setComment}
          placeholder="Write your comment here..."
        />
      </View>

      <Button title="Book Appointment" onPress={handleReservation} />

      <View style={{ marginTop: 20 }}>
        <Button title="Show Active Reservations" onPress={handleShowActiveReservations} />
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#fff',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  pickerContainer: {
    marginVertical: 10,
  },
  textAreaContainer: {
    marginVertical: 10,
  },
  textArea: {
    height: 100,
    borderColor: '#ccc',
    borderWidth: 1,
    padding: 10,
  },
});

export default HomeScreen;
