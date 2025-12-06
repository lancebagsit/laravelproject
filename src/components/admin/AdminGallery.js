import React, { useState, useEffect } from "react";
import Swal from "sweetalert2";
const API_BASE = process.env.REACT_APP_API_BASE || 'http://127.0.0.1:8000/api';


const AdminGallery = () => {
  const [galleryItems, setGalleryItems] = useState([]);
  const [newItem, setNewItem] = useState({ title: "", url: "" });
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchGalleryItems();
  }, []);

  const fetchGalleryItems = async () => {
    try {
      setIsLoading(true);
      setError(null);
      const res = await fetch(`${API_BASE}/gallery`);
      const data = await res.json();
      // Expect {id,title,url}
      setGalleryItems(data);
    } catch (err) {
      console.error("Error fetching gallery:", err);
      setError("Failed to load gallery items.");
    } finally {
      setIsLoading(false);
    }
  };

  const handleInputChange = (e) => {
    setNewItem({ ...newItem, [e.target.name]: e.target.value });
  };

  const addGalleryItem = async () => {
    if (!newItem.title || !newItem.url) {
      Swal.fire("Error", "Please fill in both title and URL", "error");
      return;
    }

    try {
      setIsLoading(true);
      const res = await fetch(`${API_BASE}/gallery`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ title: newItem.title, url: newItem.url })
      });
      if (!res.ok) throw new Error('Request failed');
      setNewItem({ title: "", url: "" });
      await fetchGalleryItems();
      Swal.fire("Success", "Gallery item added successfully", "success");
    } catch (err) {
      Swal.fire("Error", `Failed to add gallery item: ${err.message}`, "error");
    } finally {
      setIsLoading(false);
    }
  };

  const updateGalleryItem = async (id, updated) => {
    if (!updated.title || !updated.url) {
      Swal.fire("Error", "Please fill in both title and URL", "error");
      return;
    }

    try {
      const res = await fetch(`${API_BASE}/gallery/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(updated)
      });
      if (!res.ok) throw new Error('Request failed');
      fetchGalleryItems();
      Swal.fire("Success", "Gallery item updated", "success");
    } catch (err) {
      Swal.fire("Error", "Failed to update gallery item", "error");
    }
  };

  const deleteGalleryItem = async (id) => {
    const result = await Swal.fire({
      title: "Are you sure?",
      text: "This will permanently remove the item.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
    });

    if (result.isConfirmed) {
      try {
        const res = await fetch(`${API_BASE}/gallery/${id}`, { method: 'DELETE' });
        if (!res.ok) throw new Error('Request failed');
        fetchGalleryItems();
        Swal.fire("Deleted", "Gallery item removed", "success");
      } catch (err) {
        Swal.fire("Error", "Failed to delete gallery item", "error");
      }
    }
  };

  return (
    <div className="admin-section">
      <h1>Manage Gallery</h1>

      {error && <div className="error-message">{error}</div>}

      <div className="gallery-form">
        <div className="gallery-input">
          <input
            type="text"
            name="title"
            placeholder="Title"
            value={newItem.title}
            onChange={handleInputChange}
            required
          />
        </div>
        <div className="gallery-input">
          <input
            type="text"
            name="url"
            placeholder="Image URL"
            value={newItem.url}
            onChange={handleInputChange}
            required
          />
        </div>
        <button onClick={addGalleryItem} className="btn-add">
          Add Gallery Item
        </button>
      </div>

      <h4 className="admin-subtitle">Gallery Items</h4>
      {isLoading ? (
        <div className="loading-spinner">
          <div className="spinner-border" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      ) : galleryItems.length === 0 ? (
        <p>No gallery items found.</p>
      ) : (
        <div className="gallery-list">
          {galleryItems.map((item) => (
            <div key={item.id} className="gallery-card">
              <div className="gallery-input">
                <input
                  value={item.title}
                  onChange={(e) =>
                    setGalleryItems((prev) =>
                      prev.map((g) =>
                        g.id === item.id ? { ...g, title: e.target.value } : g
                      )
                    )
                  }
                  required
                />
              </div>
              <div className="gallery-input">
                <input
                  value={item.url}
                  onChange={(e) =>
                    setGalleryItems((prev) =>
                      prev.map((g) =>
                        g.id === item.id ? { ...g, url: e.target.value } : g
                      )
                    )
                  }
                  required
                />
              </div>
              <img
                src={item.url}
                alt={item.title || "Gallery image"}
                onError={(e) => {
                  e.target.onerror = null;
                  e.target.src = "https://via.placeholder.com/200?text=Image+Not+Found";
                }}
                style={{ maxWidth: "200px", maxHeight: "200px", borderRadius: "6px", objectFit: "cover", border: "1px solid #ccc" }}
              />
              <div className="card-actions">
                <button
                  className="btn-save"
                  onClick={() =>
                    updateGalleryItem(item.id, {
                      title: item.title,
                      url: item.url,
                    })
                  }
                >
                  Save
                </button>
                <button
                  className="btn-delete"
                  onClick={() => deleteGalleryItem(item.id)}
                >
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

export default AdminGallery;
