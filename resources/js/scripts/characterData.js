// characterData.js
export function getCharacterData(biography, user) {
    const {
        name,
        origin,
        worldview,
        growth,
        weight,
        age,
        eyes,
        skin,
        hair,
        race,
        gender,
        chClass,
        story,
        alliesAndOrganizations,
        characterTraits,
        ideals,
        attachments,
        weaknesses
    } = biography;

    return {
        name,
        origin,
        worldview,
        growth,
        weight,
        age,
        eyes,
        skin,
        hair,
        race,
        gender,
        chClass,
        story,
        alliesAndOrganizations,
        characterTraits,
        ideals,
        attachments,
        weaknesses,
        parent_id: user.id
    };
}
