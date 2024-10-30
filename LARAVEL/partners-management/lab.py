import random
import numpy as np

def k_means(data, k, max_iterations=100):
    centroids = random.sample(data, k)
    for _ in range(max_iterations):
        clusters = {i: [] for i in range(k)}
        for point in data:
            distances = [np.linalg.norm(np.array(point) - np.array(centroid)) for centroid in centroids]
            cluster = distances.index(min(distances))
            clusters[cluster].append(point)
        new_centroids = [np.mean(clusters[i], axis=0).tolist() if clusters[i] else centroids[i] for i in range(k)]
        if new_centroids == centroids:
            break
        centroids = new_centroids
    return clusters

data = [(1, 2), (2, 3), (3, 4), (8, 9), (9, 10), (10, 11)]
clusters = k_means(data, k=2)
print("Кластери:", clusters)
