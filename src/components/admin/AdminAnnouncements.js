import React, { useState, useEffect } from "react";
const API_BASE = process.env.REACT_APP_API_BASE || 'http://127.0.0.1:8000/api';
import Swal from "sweetalert2";


const AdminAnnouncements = () => {
  const [announcements, setAnnouncements] = useState([]);
  const [newAnnouncement, setNewAnnouncement] = useState({ title: "", content: "" });
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchAnnouncements();
  }, []);

  const fetchAnnouncements = async () => {
    try {
      setIsLoading(true);
      setError(null);
      const res = await fetch(`${API_BASE}/announcements`);
      const data = await res.json();
      setAnnouncements(data.map(a => ({ id: a.id, title: a.title, content: a.content })));
    } catch (error) {
      setError("Failed to load announcements");
    } finally {
      setIsLoading(false);
    }
  };

  const handleInputChange = (e) => {
    setNewAnnouncement({ ...newAnnouncement, [e.target.name]: e.target.value });
  };

  const addAnnouncement = async () => {
    if (!newAnnouncement.title || !newAnnouncement.content) {
      Swal.fire("Error", "Please fill in both title and content", "error");
      return;
    }

    try {
      setIsLoading(true);
      const res = await fetch(`${API_BASE}/announcements`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          title: newAnnouncement.title,
          content: newAnnouncement.content
        })
      });
      if (!res.ok) throw new Error('Request failed');
      setNewAnnouncement({ title: "", content: "" });
      await fetchAnnouncements();
      Swal.fire("Success", "Announcement added successfully", "success");
    } catch (error) {
      Swal.fire("Error", `Failed to add announcement: ${error.message}`, "error");
    } finally {
      setIsLoading(false);
    }
  };

  const updateAnnouncement = async (id, updated) => {
    if (!updated.title || !updated.content) {
      Swal.fire("Error", "Please fill in both title and content", "error");
      return;
    }

    try {
      const res = await fetch(`${API_BASE}/announcements/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(updated)
      });
      if (!res.ok) throw new Error('Request failed');
      fetchAnnouncements();
      Swal.fire("Success", "Announcement updated successfully", "success");
    } catch (error) {
      Swal.fire("Error", "Failed to update announcement", "error");
    }
  };

  const deleteAnnouncement = async (id) => {
    const result = await Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!"
    });

    if (result.isConfirmed) {
      try {
        const res = await fetch(`${API_BASE}/announcements/${id}`, { method: 'DELETE' });
        if (!res.ok) throw new Error('Request failed');
        fetchAnnouncements();
        Swal.fire("Deleted", "Announcement has been removed", "success");
      } catch (error) {
        Swal.fire("Error", "Failed to delete announcement", "error");
      }
    }
  };

  return (
    <div className="admin-section">
      <h1>Manage Announcements</h1>
      
      {error && (
        <div className="error-message">
          {error}
        </div>
      )}

      <div className="announcement-form">
        <div className="announcement-input">
          <input
            type="text"
            name="title"
            placeholder="Title"
            value={newAnnouncement.title}
            onChange={handleInputChange}
            required
          />
        </div>
        <div className="announcement-input">
          <textarea
            name="content"
            placeholder="Content"
            value={newAnnouncement.content}
            onChange={handleInputChange}
            required
            rows="3"
          ></textarea>
        </div>
        <button onClick={addAnnouncement} className="btn-add">
          Add Announcement
        </button>
      </div>

      <h4 className="admin-subtitle">Existing Announcements</h4>
      {isLoading ? (
        <div className="loading-spinner">
          <div className="spinner-border" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      ) : announcements.length === 0 ? (
        <p>No announcements found.</p>
      ) : (
        <div className="announcement-list">
          {announcements.map((a) => (
            <div key={a.id} className="announcement-card">
              <div className="announcement-input">
                <input
                  value={a.title}
                  onChange={(e) =>
                    setAnnouncements(prev =>
                      prev.map(item =>
                        item.id === a.id ? { ...item, title: e.target.value } : item
                      )
                    )
                  }
                  required
                />
              </div>
              <div className="announcement-input">
                <textarea
                  value={a.content}
                  onChange={(e) =>
                    setAnnouncements(prev =>
                      prev.map(item =>
                        item.id === a.id ? { ...item, content: e.target.value } : item
                      )
                    )
                  }
                  required
                  rows="3"
                />
              </div>
              <div className="card-actions">
                <button
                  className="btn-save"
                  onClick={() => updateAnnouncement(a.id, { title: a.title, content: a.content })}
                >
                  Save
                </button>
                <button className="btn-delete" onClick={() => deleteAnnouncement(a.id)}>
                  Delete
                </button>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default AdminAnnouncements;
