import React, { useEffect, useState, useCallback } from 'react';
import { View, Text, StyleSheet, FlatList, Button } from 'react-native';
import axios from 'axios';

const salonNames = {
  1: 'Hairway to Heaven',
  2: 'Trim Trends',
  3: 'Hair Hub',
  4: 'Timeless Trims',
  5: 'Vajers Place',
  6: 'Bark and Bath Boutique'
};

const ActiveReservations = ({ route }) => {
  const { userId } = route.params;
  const [reservations, setReservations] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchActiveReservations = useCallback(async () => {
    try {
      setLoading(true);
      const response = await axios.get(`http://kv.stud.vts.su.ac.rs/fetch_reservations.php?user_id=${userId}`);
      setReservations(response.data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching reservations:', error);
      alert('Failed to fetch reservations.');
      setLoading(false);
    }
  }, [userId]);

  useEffect(() => {
    fetchActiveReservations();
  }, [fetchActiveReservations]);

  const cancelReservation = async (reservationId) => {
    console.log(reservationId);
    try {
      await axios.patch(
        'http://kv.stud.vts.su.ac.rs/cancel_reservations.php',
        { reservation_id: reservationId },
        { headers: { 'Content-Type': 'application/json' } }
      );
      alert('Reservation cancelled successfully.');
      fetchActiveReservations();
    } catch (error) {
      console.error('Error cancelling reservation:', error);
      alert('Failed to cancel reservation.');
    }
  };

  const deleteReservation = async (reservationId) => {
    console.log(reservationId);
    try {
      await axios.delete('http://kv.stud.vts.su.ac.rs/delete_reservations.php', {
        headers: { 'Content-Type': 'application/json' },
        data: { reservation_id: reservationId }, // Include the reservation_id here
      });
      alert('Reservation deleted successfully.');
      fetchActiveReservations();
    } catch (error) {
      console.error('Error deleting reservation:', error);
      alert('Failed to delete reservation.');
    }
  };

  const renderReservation = ({ item }) => (
    <View style={styles.reservationItem}>
      <Text style={styles.reservationText}>Reservation ID: {item.reservation_id}</Text>
      <Text style={styles.reservationText}>User ID: {item.user_id}</Text>
      <Text style={styles.reservationText}>Store ID: {salonNames[item.store_id]}</Text>
      <Text style={styles.reservationText}>Date: {item.date}</Text>
      <Text style={styles.reservationText}>Start Time: {item.start_time}</Text>
      <Text style={styles.reservationText}>End Time: {item.end_time}</Text>
      <Text style={styles.reservationText}>Treatment Name: {item.treatment_name}</Text>
      <Text style={styles.reservationText}>Comment: {item.comment}</Text>
      <Button
        title="Cancel Reservation"
        onPress={() => cancelReservation(item.reservation_id)}
        color="orange"
      />
      <Button
        title="Delete Reservation"
        onPress={() => deleteReservation(item.reservation_id)}
        color="red"
      />
    </View>
  );

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Active Reservations</Text>
      {loading ? (
        <Text>Loading...</Text>
      ) : reservations.length > 0 ? (
        <FlatList
          data={reservations}
          keyExtractor={(item) => item.reservation_id.toString()}
          renderItem={renderReservation}
        />
      ) : (
        <Text>No active reservations found.</Text>
      )}
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
  reservationItem: {
    padding: 15,
    borderBottomColor: '#ccc',
    borderBottomWidth: 1,
    marginBottom: 10,
  },
  reservationText: {
    fontSize: 16,
  },
});

export default ActiveReservations;
